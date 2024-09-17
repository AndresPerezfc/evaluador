<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Innovation;
use App\Models\Evaluation;
use App\Models\Criterio;
use Illuminate\Support\Facades\Auth;

class InnovationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Obtener los parámetros de ordenamiento, con valores por defecto
        $sortBy = $request->query('sort_by', 'puntaje'); // Por defecto, ordena por 'puntaje'
        $sortDirection = $request->query('sort_direction', 'desc'); // Por defecto, orden descendente

        // Validar que el valor de $sortBy sea uno de los permitidos (titulo, innovador, puntaje)
        if (!in_array($sortBy, ['titulo', 'innovador', 'puntaje', 'rol_autor'])) {
            $sortBy = 'puntaje';
        }

        // Validar que la dirección de orden sea válida (asc o desc)
        if (!in_array($sortDirection, ['asc', 'desc'])) {
            $sortDirection = 'desc';
        }

        // Obtener las innovaciones con ordenamiento dinámico
        $innovations = Innovation::whereIn('category_id', [1, 3])
            ->orderBy($sortBy, $sortDirection) // Ordenar según los parámetros de usuario
            ->get();

        foreach ($innovations as $innovation) {
            // Contar las evaluaciones por usuario
            $innovation->evaluaciones_por_usuario = Evaluation::where('innovation_id', $innovation->id)
                ->distinct('user_id')
                ->count('user_id');

            // Verificar si el usuario actual ha evaluado esta innovación
            $innovation->evaluado_por_usuario_actual = Evaluation::where('innovation_id', $innovation->id)
                ->where('user_id', Auth::user()->id)
                ->exists();
        }

        // Pasar los datos a la vista, incluyendo sortBy y sortDirection
        return view('innovations.index', compact('innovations', 'sortBy', 'sortDirection'));
    }

    /**
     * Show the form for creating a new resource.
     */
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
    public function show(Innovation $innovation)
    {
        return view('innovations.show', compact('innovation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Innovation $innovation)
    {
        // Obtener los criterios asociados a la categoría de la innovación
        $criterios = Criterio::where('category_id', $innovation->category_id)->get();

        // Obtener las evaluaciones anteriores hechas por el usuario para esta innovación
        $evaluaciones = Evaluation::where('innovation_id', $innovation->id)
            ->where('user_id', Auth::user()->id)
            ->get()
            ->keyBy('criterio_id'); // Organiza las evaluaciones por criterio

        return view('innovations.edit', compact('innovation', 'criterios', 'evaluaciones'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Innovation $innovation)
    {
        // Validar los datos de la solicitud
        $validated = $request->validate([
            'criterios.*.id' => 'required|exists:criterios,id',
            'criterios.*.puntaje' => 'required|integer|min:0', // Valida que sea un número entero positivo
            'criterios.*.comentario' => 'nullable|string',
        ]);

        // Inicializar la suma total de puntajes para esta evaluación
        $puntajeUsuario = 0;

        // Iterar sobre los criterios enviados en la solicitud
        foreach ($validated['criterios'] as $criterioData) {
            // Obtener el criterio para acceder a su puntaje (score)
            $criterio = Criterio::find($criterioData['id']);

            // Crear o actualizar la evaluación del usuario para este criterio y la innovación
            $evaluation = Evaluation::updateOrCreate(
                [
                    'user_id' => Auth::user()->id,
                    'innovation_id' => $innovation->id,
                    'criterio_id' => $criterio->id,
                ],
                [
                    'puntaje' => $criterioData['puntaje'],
                    'comentario' => $criterioData['comentario'] ?? null,
                ],
            );

            // Sumar el puntaje ponderado al total usando el score del criterio
            $puntajeUsuario += $criterioData['puntaje'];
        }

        $totalPuntajeActual = Evaluation::where('innovation_id', $innovation->id)->sum('puntaje');

        // Obtener las evaluaciones de esta innovación, agrupadas por usuario
        $evaluacionesPorUsuario = Evaluation::where('innovation_id', $innovation->id)
            ->distinct('user_id')
            ->count('user_id'); // Contar los usuarios únicos que han evaluado esta innovación

        // Calcular el promedio dividiendo entre el número de usuarios únicos que evaluaron la innovación
        if ($evaluacionesPorUsuario > 0) {
            $innovation->puntaje = $totalPuntajeActual / $evaluacionesPorUsuario;
        } else {
            $innovation->puntaje = $totalPuntajeActual; // Si es la primera evaluación
        }

        if ($innovation->extra_puntos && $innovation->puntaje < 100) {
            $innovation->puntaje = $innovation->puntaje + 10;
        }

        $innovation->save();

        // Agregar un mensaje de éxito a la sesión
        return redirect()->route('innovations.index')->with('success', 'La evaluación de la innovación se ha guardado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
