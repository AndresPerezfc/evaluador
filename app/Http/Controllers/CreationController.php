<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Creation;
use App\Models\CreationComment;
use App\Models\EvaluationCreation;
use App\Models\Criterio;
use Illuminate\Support\Facades\Auth;

class CreationController extends Controller
{

    public function index(Request $request)
    {
        // Obtener los parámetros de ordenamiento, con valores por defecto
        $sortBy = $request->query('sort_by', 'id'); // Por defecto, ordena por 'puntaje'
        $sortDirection = $request->query('sort_direction', 'asc'); // Por defecto, orden descendente

        // Validar que el valor de $sortBy sea uno de los permitidos (titulo, innovador, puntaje)
        if (!in_array($sortBy, ['titulo', 'innovador', 'puntaje', 'rol_autor'])) {
            $sortBy = 'id';
        }

        // Validar que la dirección de orden sea válida (asc o desc)
        if (!in_array($sortDirection, ['asc', 'desc'])) {
            $sortDirection = 'desc';
        }

        // Obtener las innovaciones con ordenamiento dinámico
        $creations = Creation::where('category_id', 2)
            ->orderBy($sortBy, $sortDirection) // Ordenar según los parámetros de usuario
            ->get();

        foreach ($creations as $creation) {
            $creation->evaluaciones_por_usuario = EvaluationCreation::where('creation_id', $creation->id)
                ->distinct('user_id')
                ->count('user_id');

            $creation->evaluado_por_usuario_actual = EvaluationCreation::where('creation_id', $creation->id)
                ->where('user_id', Auth::user()->id)
                ->exists();
        }

        // Pasar los datos a la vista, incluyendo sortBy y sortDirection
        return view('creations.index', compact('creations', 'sortBy', 'sortDirection'));
    }


    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function edit(Creation $creation)
    {
        // Obtener los criterios asociados a la categoría de la innovación
        $criterios = Criterio::where('category_id', $creation->category_id)->get();

        // Obtener las evaluaciones anteriores hechas por el usuario para esta innovación
        $evaluaciones = EvaluationCreation::where('creation_id', $creation->id)
            ->where('user_id', Auth::user()->id)
            ->get()
            ->keyBy('criterio_id'); // Organiza las evaluaciones por criterio

        // Obtener la suma total del puntaje del usuario actual
        $evaluacionesUsuarioActual = EvaluationCreation::where('creation_id', $creation->id)
            ->where('user_id', Auth::user()->id);

        // Verificar si el usuario ha hecho alguna evaluación
        if ($evaluacionesUsuarioActual->exists()) {
            $puntajeUsuarioActual = $evaluacionesUsuarioActual->sum('puntaje');
        } else {
            $puntajeUsuarioActual = null; // Usuario no ha evaluado
        }

        // Obtener evaluaciones de otros usuarios para esta innovación, excluyendo al usuario actual
        $otrasEvaluaciones = EvaluationCreation::where('creation_id', $creation->id)
            ->where('user_id', '!=', Auth::user()->id) // Excluir al usuario autenticado
            ->selectRaw('user_id, SUM(puntaje) as total_puntaje') // Sumar los puntajes por usuario
            ->groupBy('user_id') // Agrupar por usuario
            ->with('user') // Cargar la información del usuario que hizo la evaluación
            ->get(); // Obtenemos las evaluaciones agrupadas y con la suma de puntajes


        $detalleevaluaciones = EvaluationCreation::with('criterio', 'user')
            ->where('creation_id', $creation->id)
            ->where('user_id', '!=', Auth::user()->id)
            ->get()
            ->groupBy('user_id');  // Agrupar por user_id


        // Obtener comentarios de la innovación de la tabla creation_comments
        $comentarioEvaluacion = CreationComment::where('creation_id', $creation->id)
            ->where('user_id', Auth::user()->id) // Solo el comentario del usuario actual
            ->first(); // Solo obtenemos un comentario

        // Obtener los comentarios de todos los evaluadores para la innovación actual
        $comentarios = CreationComment::where('creation_id', $creation->id)->get()->keyBy('user_id');

        return view('creations.edit', compact('creation', 'criterios', 'evaluaciones',  'puntajeUsuarioActual', 'otrasEvaluaciones', 'detalleevaluaciones', 'comentarioEvaluacion', 'comentarios'));
    }


    public function update(Request $request, Creation $creation)
    {

        // Validar los datos de la solicitud
        $validated = $request->validate([
            'criterios.*.id' => 'required|exists:criterios,id',
            'criterios.*.puntaje' => 'required|integer|min:0', // Valida que sea un número entero positivo
            'criterios.*.comentario' => 'nullable|string',
            'comentario_general' => 'nullable|string',
        ]);

        // Inicializar la suma total de puntajes para esta evaluación
        $puntajeUsuario = 0;

        // Iterar sobre los criterios enviados en la solicitud
        foreach ($validated['criterios'] as $criterioData) {
            // Obtener el criterio para acceder a su puntaje (score)
            $criterio = Criterio::find($criterioData['id']);

            // Crear o actualizar la evaluación del usuario para este criterio y la innovación
            $evaluation = EvaluationCreation::updateOrCreate(
                [
                    'user_id' => Auth::user()->id,
                    'creation_id' => $creation->id,
                    'criterio_id' => $criterio->id,
                    'tipo' => 'creations'
                ],
                [
                    'puntaje' => $criterioData['puntaje'],
                    'comentario' => $criterioData['comentario'] ?? null,
                ],
            );

            // Sumar el puntaje ponderado al total usando el score del criterio
            $puntajeUsuario += $criterioData['puntaje'];
        }

        // Actualizar el comentario general

        // Guardar o actualizar el comentario general en la tabla creation_comments
        CreationComment::updateOrCreate(
            [
                'user_id' => Auth::user()->id,
                'creation_id' => $creation->id,
            ],
            [
                'comentario' => $validated['comentario_general'] ?? null,
            ]
        );


        $totalPuntajeActual = EvaluationCreation::where('creation_id', $creation->id)->sum('puntaje');

        // Obtener las evaluaciones de esta innovación, agrupadas por usuario
        $evaluacionesPorUsuario = EvaluationCreation::where('creation_id', $creation->id)
            ->distinct('user_id')
            ->count('user_id'); // Contar los usuarios únicos que han evaluado esta innovación

        // Calcular el promedio dividiendo entre el número de usuarios únicos que evaluaron la innovación
        if ($evaluacionesPorUsuario > 0) {
            $creation->puntaje = $totalPuntajeActual / $evaluacionesPorUsuario;
        } else {
            $creation->puntaje = $totalPuntajeActual; // Si es la primera evaluación
        }

        if ($creation->extra_puntos && $creation->puntaje < 100) {
            $creation->puntaje = $creation->puntaje + 10;
        }

        $creation->save();
        return back()->with('success', 'Innovación evaluada con exito');

    }


    public function destroy(string $id) {}
}
