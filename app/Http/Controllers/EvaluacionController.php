<?php

namespace App\Http\Controllers;

use App\Models\Evaluacion;
use Illuminate\Http\Request;

class EvaluacionController extends Controller
{
    /**
     * Muestra todas las evaluaciones.
     */
    public function index()
    {
        $evaluaciones = Evaluacion::with('usuario', 'apartamento')->get();
        return response()->json($evaluaciones);
    }

    /**
     * Devuelve los datos necesarios para el formulario de creación.
     */
    public function create()
    {
        return response()->json(['message' => 'Formulario de creación de evaluaciones']);
    }

    /**
     * Almacena una nueva evaluación.
     */
    public function store(Request $request)
    {
        $request->validate([
            'usuario_id' => 'required|exists:usuario,id',
            'apartamento_id' => 'required|exists:apartamento,id',
            'calificacion' => 'required|integer|min:1|max:5',
            'comentario' => 'nullable|string|max:500',
            'fecha_evaluacion' => 'required|date',
        ]);

        $evaluacion = Evaluacion::create($request->all());
        return response()->json($evaluacion, 201);
    }

    /**
     * Muestra una evaluación específica.
     */
    public function show($id)
    {
        $evaluacion = Evaluacion::find($id);
        if ($evaluacion) {
            return response()->json($evaluacion);
        }
        return response()->json(['message' => 'Evaluación no encontrada'], 404);
    }

    /**
     * Devuelve los datos necesarios para el formulario de edición.
     */
    public function edit($id)
    {
        $evaluacion = Evaluacion::find($id);
        if ($evaluacion) {
            return response()->json($evaluacion);
        }
        return response()->json(['message' => 'Evaluación no encontrada'], 404);
    }

    /**
     * Actualiza una evaluación en la base de datos.
     */
    public function update(Request $request, $id)
    {
        $evaluacion = Evaluacion::find($id);
        if ($evaluacion) {
            $request->validate([
                'usuario_id' => 'required|exists:usuario,id',
                'apartamento_id' => 'required|exists:apartamento,id',
                'calificacion' => 'required|integer|min:1|max:5',
                'comentario' => 'nullable|string|max:500',
                'fecha_evaluacion' => 'required|date',
            ]);

            $evaluacion->update($request->all());
            return response()->json($evaluacion);
        }
        return response()->json(['message' => 'Evaluación no encontrada'], 404);
    }

    /**
     * Elimina una evaluación de la base de datos.
     */
    public function destroy($id)
    {
        $evaluacion = Evaluacion::find($id);
        if ($evaluacion) {
            $evaluacion->delete();
            return response()->json(['message' => 'Evaluación eliminada correctamente']);
        }
        return response()->json(['message' => 'Evaluación no encontrada'], 404);
    }
}
