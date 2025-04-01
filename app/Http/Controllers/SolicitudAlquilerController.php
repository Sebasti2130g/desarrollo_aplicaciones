<?php

namespace App\Http\Controllers;

use App\Models\SolicitudAlquiler;
use Illuminate\Http\Request;

class SolicitudAlquilerController extends Controller
{
    /**
     * Muestra todas las solicitudes de alquiler.
     */
    public function index()
    {
        $solicitudes = SolicitudAlquiler::with('usuario', 'apartamento')->get();
        return response()->json($solicitudes);
    }

    /**
     * Devuelve los datos necesarios para el formulario de creación.
     */
    public function create()
    {
        return response()->json(['message' => 'Formulario de creación de solicitudes de alquiler']);
    }

    /**
     * Almacena una nueva solicitud de alquiler.
     */
    public function store(Request $request)
    {
        $request->validate([
            'usuario_id' => 'required|exists:usuario,id',
            'apartamento_id' => 'required|exists:apartamento,id',
            'fecha_solicitud' => 'required|date',
            'estado_solicitud' => 'required|string|max:255',
        ]);

        $solicitud = SolicitudAlquiler::create($request->all());
        return response()->json($solicitud, 201);
    }

    /**
     * Muestra una solicitud de alquiler específica.
     */
    public function show($id)
    {
        $solicitud = SolicitudAlquiler::find($id);
        if ($solicitud) {
            return response()->json($solicitud);
        }
        return response()->json(['message' => 'Solicitud de alquiler no encontrada'], 404);
    }

    /**
     * Devuelve los datos necesarios para el formulario de edición.
     */
    public function edit($id)
    {
        $solicitud = SolicitudAlquiler::find($id);
        if ($solicitud) {
            return response()->json($solicitud);
        }
        return response()->json(['message' => 'Solicitud de alquiler no encontrada'], 404);
    }

    /**
     * Actualiza una solicitud de alquiler en la base de datos.
     */
    public function update(Request $request, $id)
    {
        $solicitud = SolicitudAlquiler::find($id);
        if ($solicitud) {
            $request->validate([
                'usuario_id' => 'required|exists:usuario,id',
                'apartamento_id' => 'required|exists:apartamento,id',
                'fecha_solicitud' => 'required|date',
                'estado_solicitud' => 'required|string|max:255',
            ]);

            $solicitud->update($request->all());
            return response()->json($solicitud);
        }
        return response()->json(['message' => 'Solicitud de alquiler no encontrada'], 404);
    }

    /**
     * Elimina una solicitud de alquiler de la base de datos.
     */
    public function destroy($id)
    {
        $solicitud = SolicitudAlquiler::find($id);
        if ($solicitud) {
            $solicitud->delete();
            return response()->json(['message' => 'Solicitud de alquiler eliminada correctamente']);
        }
        return response()->json(['message' => 'Solicitud de alquiler no encontrada'], 404);
    }
}
