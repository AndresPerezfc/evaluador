<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Innovation;
use App\Models\Evaluation;
use App\Models\Criterio;
use Auth;

class InnovationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $innovations = Innovation::orderBy('id', 'desc')->paginate(10);
        return view('innovations.index', compact('innovations'));
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

        $criterios = $innovation->category->criterios;
            return view('innovations.edit', compact('innovation', 'criterios'));
    
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Innovation $innovation)
    {
        {
             // Validar los datos de la solicitud
    $validated = $request->validate([
        'criterios.*.id' => 'required|exists:criterios,id',
        'criterios.*.puntaje' => 'required|integer|min:0', // Valida que sea un número entero positivo
        'criterios.*.comentario' => 'nullable|string',
    ]);

    // Inicializar la suma total de puntajes
    $totalPuntaje = 0;

    // Iterar sobre los criterios enviados en la solicitud
    foreach ($validated['criterios'] as $criterioData) {
        // Obtener el criterio para acceder a su puntaje (score)
        $criterio = Criterio::find($criterioData['id']);

        // Obtener o crear la evaluación del usuario para este criterio y la innovación
        $evaluation = Evaluation::updateOrCreate(
            [
                'user_id' => 1,
                'innovation_id' => $innovation->id,
                'criterio_id' => $criterio->id,
            ],
            [
                'puntaje' => $criterioData['puntaje'],
                'comentario' => $criterioData['comentario'] ?? null,
            ]
        );

        // Sumar el puntaje ponderado al total usando el score del criterio
        $totalPuntaje += $criterioData['puntaje'] * $criterio->score / 100;
    } 

    // Actualizar el puntaje total de la innovación
    $innovation->puntaje = $totalPuntaje;
    $innovation->save();

    return redirect()->route('innovations.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
