<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Innovation;
use App\Models\Evaluation;
use App\Models\Criterio;
use Illuminate\Support\Facades\Auth;

class CreationController extends Controller
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
        $innovations = Innovation::where('category_id', 2)
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
        return view('creations.index', compact('innovations', 'sortBy', 'sortDirection'));
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
