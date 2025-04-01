<?php

namespace App\Http\Controllers;

use App\Models\Queja;
use Illuminate\Http\Request;

class QuejaController extends Controller
{
    /**
     * Mostrar todas las quejas.
     */
    public function index()
    {
        $quejas = Queja::with('usuario')->get();
        return response()->json($quejas);
    }

    /**
     * Mostrar una queja específica.
     */
    public function show($id)
    {
        $queja = Queja::find($id);
        if ($queja) {
            return response()->json($queja);
        }
        return response()->json(['message' => 'Queja no encontrada'], 404);
    }

    /**
     * Método de creación (solo muestra un mensaje en la API).
     */
    public function create()
    {
        return response()->json(['message' => 'Formulario de creación de quejas']);
    }

    /**
     * Almacenar una nueva queja.
     */
    public function store(Request $request)
    {
        $request->validate([
            'usuario_id' => 'required|exists:usuario,id',
            'descripcion' => 'required|string',
            'tipo' => 'required|string',
            'fecha_envio' => 'required|date',
        ]);

        $queja = Queja::create($request->all());
        return response()->json($queja, 201);
    }

    /**
     * Actualizar una queja existente.
     */
    public function update(Request $request, $id)
    {
        $queja = Queja::find($id);
        if ($queja) {
            $request->validate([
                'usuario_id' => 'required|exists:usuario,id',
                'descripcion' => 'required|string',
                'tipo' => 'required|string',
                'fecha_envio' => 'required|date',
            ]);

            $queja->update($request->all());
            return response()->json($queja);
        }
        return response()->json(['message' => 'Queja no encontrada'], 404);
    }

    /**
     * Eliminar una queja.
     */
    public function destroy($id)
    {
        $queja = Queja::find($id);
        if ($queja) {
            $queja->delete();
            return response()->json(['message' => 'Queja eliminada correctamente']);
        }
        return response()->json(['message' => 'Queja no encontrada'], 404);
    }
}
