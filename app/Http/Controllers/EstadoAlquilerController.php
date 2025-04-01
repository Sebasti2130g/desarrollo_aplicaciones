<?php

namespace App\Http\Controllers;

use App\Models\EstadoAlquiler;
use Illuminate\Http\Request;

class EstadoAlquilerController extends Controller
{
    /**
     * Muestra todos los estados de alquiler.
     */
    public function index()
    {
        $estadosAlquiler = EstadoAlquiler::with('contrato', 'usuario')->get();
        return response()->json($estadosAlquiler);
    }

    /**
     * Muestra un estado de alquiler específico.
     */
    public function show($id)
    {
        $estadoAlquiler = EstadoAlquiler::with('contrato', 'usuario')->find($id);
        if ($estadoAlquiler) {
            return response()->json($estadoAlquiler);
        }
        return response()->json(['message' => 'Estado de alquiler no encontrado'], 404);
    }

    /**
     * Devuelve los datos necesarios para el formulario de creación de estado de alquiler.
     */
    public function create()
    {
        return response()->json(['message' => 'Formulario de creación de estado de alquiler']);
    }

    /**
     * Almacena un nuevo estado de alquiler en la base de datos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'contrato_id' => 'required|exists:contrato,id',
            'usuario_id' => 'required|exists:usuario,id',
            'estado' => 'required|string|max:255',
            'fecha_reporte' => 'required|date',
        ]);

        $estadoAlquiler = EstadoAlquiler::create($request->all());
        return response()->json($estadoAlquiler, 201);
    }

    /**
     * Actualiza un estado de alquiler existente.
     */
    public function update(Request $request, $id)
    {
        $estadoAlquiler = EstadoAlquiler::find($id);
        if ($estadoAlquiler) {
            $request->validate([
                'contrato_id' => 'required|exists:contrato,id',
                'usuario_id' => 'required|exists:usuario,id',
                'estado' => 'required|string|max:255',
                'fecha_reporte' => 'required|date',
            ]);

            $estadoAlquiler->update($request->all());
            return response()->json($estadoAlquiler);
        }
        return response()->json(['message' => 'Estado de alquiler no encontrado'], 404);
    }

    /**
     * Elimina un estado de alquiler.
     */
    public function destroy($id)
    {
        $estadoAlquiler = EstadoAlquiler::find($id);
        if ($estadoAlquiler) {
            $estadoAlquiler->delete();
            return response()->json(['message' => 'Estado de alquiler eliminado correctamente']);
        }
        return response()->json(['message' => 'Estado de alquiler no encontrado'], 404);
    }
}
