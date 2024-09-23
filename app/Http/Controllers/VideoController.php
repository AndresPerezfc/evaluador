<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Video;
use App\Models\EvaluationVideo;
use App\Models\Criterio;
use Illuminate\Support\Facades\Auth;

class VideoController extends Controller
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
        $videos = Video::where('category_id', 4)
            ->whereNotIn('id', [5, 7, 8, 10]) // Excluir los IDs específicos
            ->orderBy($sortBy, $sortDirection) // Ordenar según los parámetros de usuario
            ->get();

        foreach ($videos as $video) {
            $video->evaluaciones_por_usuario = EvaluationVideo::where('video_id', $video->id)
                ->distinct('user_id')
                ->count('user_id');

            $video->evaluado_por_usuario_actual = EvaluationVideo::where('video_id', $video->id)
                ->where('user_id', Auth::user()->id)
                ->exists();
        }

        // Pasar los datos a la vista, incluyendo sortBy y sortDirection
        return view('videos.index', compact('videos', 'sortBy', 'sortDirection'));
    }


    public function create() {}

    public function store(Request $request) {}


    public function show(string $id) {}


    public function edit(Video $video)
    {
        // Obtener los criterios asociados a la categoría de la innovación
        $criterios = Criterio::where('category_id', $video->category_id)->get();

        // Obtener las evaluaciones anteriores hechas por el usuario actual para esta innovación
        $evaluaciones = EvaluationVideo::where('video_id', $video->id)
            ->where('user_id', Auth::user()->id)
            ->get()
            ->keyBy('criterio_id'); // Organiza las evaluaciones por criterio


        // Obtener la suma total del puntaje del usuario actual
        $evaluacionesUsuarioActual = EvaluationVideo::where('video_id', $video->id)
            ->where('user_id', Auth::user()->id);

        // Verificar si el usuario ha hecho alguna evaluación
        if ($evaluacionesUsuarioActual->exists()) {
            $puntajeUsuarioActual = $evaluacionesUsuarioActual->sum('puntaje');
        } else {
            $puntajeUsuarioActual = null; // Usuario no ha evaluado
        }

        // Obtener evaluaciones de otros usuarios para esta innovación, excluyendo al usuario actual
        $otrasEvaluaciones = EvaluationVideo::where('video_id', $video->id)
            ->where('user_id', '!=', Auth::user()->id) // Excluir al usuario autenticado
            ->selectRaw('user_id, SUM(puntaje) as total_puntaje') // Sumar los puntajes por usuario
            ->groupBy('user_id') // Agrupar por usuario
            ->with('user') // Cargar la información del usuario que hizo la evaluación
            ->get(); // Obtenemos las evaluaciones agrupadas y con la suma de puntajes

        // Pasar las evaluaciones y los usuarios a la vista
        return view('videos.edit', compact('video', 'criterios', 'evaluaciones', 'puntajeUsuarioActual', 'otrasEvaluaciones'));
    }




    public function update(Request $request, Video $video)
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
            $evaluation = EvaluationVideo::updateOrCreate(
                [
                    'user_id' => Auth::user()->id,
                    'video_id' => $video->id,
                    'criterio_id' => $criterio->id,
                    'tipo' => 'video'
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
        $video->comentario_general = $validated['comentario_general'] ?? null;

        $totalPuntajeActual = EvaluationVideo::where('video_id', $video->id)->sum('puntaje');

        // Obtener las evaluaciones de esta innovación, agrupadas por usuario
        $evaluacionesPorUsuario = EvaluationVideo::where('video_id', $video->id)
            ->distinct('user_id')
            ->count('user_id'); // Contar los usuarios únicos que han evaluado esta innovación

        // Calcular el promedio dividiendo entre el número de usuarios únicos que evaluaron la innovación
        if ($evaluacionesPorUsuario > 0) {
            $video->puntaje = $totalPuntajeActual / $evaluacionesPorUsuario;
        } else {
            $video->puntaje = $totalPuntajeActual; // Si es la primera evaluación
        }

        if ($video->extra_puntos && $video->puntaje < 100) {
            $video->puntaje = $video->puntaje + 10;
        }

        $video->save();

        // Agregar un mensaje de éxito a la sesión
        return redirect()->route('videos.index')->with('success', 'La evaluación de la innovación se ha guardado correctamente.');
    }


    public function destroy(string $id)
    {
        //
    }
}
