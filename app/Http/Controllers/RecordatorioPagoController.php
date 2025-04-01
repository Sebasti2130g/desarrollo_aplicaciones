<?php

namespace App\Http\Controllers;

use App\Models\RecordatorioPago;
use Illuminate\Http\Request;

class RecordatorioPagoController extends Controller
{
    /**
     * Muestra todos los recordatorios de pago.
     */
    public function index()
    {
        $recordatorios = RecordatorioPago::with('usuario')->get();
        return response()->json($recordatorios);
    }

    /**
     * Devuelve los datos necesarios para el formulario de creación.
     */
    public function create()
    {
        return response()->json(['message' => 'Formulario de creación de recordatorios de pago']);
    }

    /**
     * Almacena un nuevo recordatorio de pago.
     */
    public function store(Request $request)
    {
        $request->validate([
            'usuario_id' => 'required|exists:usuario,id',
            'medio' => 'required|string|max:255',
            'fecha_envio' => 'required|date',
        ]);

        $recordatorio = RecordatorioPago::create($request->all());
        return response()->json($recordatorio, 201);
    }

    /**
     * Muestra un recordatorio de pago específico.
     */
    public function show($id)
    {
        $recordatorio = RecordatorioPago::find($id);
        if ($recordatorio) {
            return response()->json($recordatorio);
        }
        return response()->json(['message' => 'Recordatorio de pago no encontrado'], 404);
    }

    /**
     * Devuelve los datos necesarios para el formulario de edición.
     */
    public function edit($id)
    {
        $recordatorio = RecordatorioPago::find($id);
        if ($recordatorio) {
            return response()->json($recordatorio);
        }
        return response()->json(['message' => 'Recordatorio de pago no encontrado'], 404);
    }

    /**
     * Actualiza un recordatorio de pago en la base de datos.
     */
    public function update(Request $request, $id)
    {
        $recordatorio = RecordatorioPago::find($id);
        if ($recordatorio) {
            $request->validate([
                'usuario_id' => 'required|exists:usuario,id',
                'medio' => 'required|string|max:255',
                'fecha_envio' => 'required|date',
            ]);

            $recordatorio->update($request->all());
            return response()->json($recordatorio);
        }
        return response()->json(['message' => 'Recordatorio de pago no encontrado'], 404);
    }

    /**
     * Elimina un recordatorio de pago de la base de datos.
     */
    public function destroy($id)
    {
        $recordatorio = RecordatorioPago::find($id);
        if ($recordatorio) {
            $recordatorio->delete();
            return response()->json(['message' => 'Recordatorio de pago eliminado correctamente']);
        }
        return response()->json(['message' => 'Recordatorio de pago no encontrado'], 404);
    }
}
