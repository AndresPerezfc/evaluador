<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Innovation;

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
    public function update(Request $request, string $id)
    {
        {
            // Validar los puntajes
            $request->validate([
                'criterio1' => 'required|integer|min:0|max:40',
                'criterio2' => 'required|integer|min:0|max:20',
                'criterio3' => 'required|integer|min:0|max:20',
                'criterio4' => 'required|integer|min:0|max:10',
                'criterio5' => 'required|integer|min:0|max:10',
            ]);
    
            // Obtener la innovación que se va a evaluar
            $innovation = Innovation::findOrFail($id);
    
            // Calcular el puntaje total basado en los puntajes de los criterios
            $totalPuntaje = $request->criterio1 + $request->criterio2 + $request->criterio3 + $request->criterio4 + $request->criterio5;
            $totalPuntaje = ($totalPuntaje / 3);
            // Guardar el puntaje total en la innovación
            $innovation->puntaje = $totalPuntaje;
            $innovation->save();
    
            // Redirigir de vuelta con un mensaje de éxito
            return redirect()->route('innovations.index')->with('success', 'Innovación evaluada exitosamente con un puntaje total de ' . $totalPuntaje);
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
