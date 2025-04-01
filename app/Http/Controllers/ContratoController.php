<?php

namespace App\Http\Controllers;

use App\Models\Contrato;
use Illuminate\Http\Request;

class ContratoController extends Controller
{
    /**
     * Muestra todos los contratos.
     */
    public function index()
    {
        $contratos = Contrato::with('usuario', 'apartamento')->get();
        return response()->json($contratos);
    }

    /**
     * Muestra un contrato específico.
     */
    public function show($id)
    {
        $contrato = Contrato::with('usuario', 'apartamento')->find($id);
        if ($contrato) {
            return response()->json($contrato);
        }
        return response()->json(['message' => 'Contrato no encontrado'], 404);
    }

    /**
     * Devuelve los datos necesarios para el formulario de creación de contrato.
     */
    public function create()
    {
        return response()->json(['message' => 'Formulario de creación de contratos']);
    }

    /**
     * Almacena un nuevo contrato en la base de datos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'usuario_id' => 'required|exists:usuario,id',
            'apartamento_id' => 'required|exists:apartamento,id',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date',
            'firma_digital' => 'required|string',
        ]);

        $contrato = Contrato::create($request->all());
        return response()->json($contrato, 201);
    }

    /**
     * Actualiza un contrato existente.
     */
    public function update(Request $request, $id)
    {
        $contrato = Contrato::find($id);
        if ($contrato) {
            $request->validate([
                'usuario_id' => 'required|exists:usuario,id',
                'apartamento_id' => 'required|exists:apartamento,id',
                'fecha_inicio' => 'required|date',
                'fecha_fin' => 'required|date',
                'firma_digital' => 'required|string',
            ]);

            $contrato->update($request->all());
            return response()->json($contrato);
        }
        return response()->json(['message' => 'Contrato no encontrado'], 404);
    }

    /**
     * Elimina un contrato.
     */
    public function destroy($id)
    {
        $contrato = Contrato::find($id);
        if ($contrato) {
            $contrato->delete();
            return response()->json(['message' => 'Contrato eliminado correctamente']);
        }
        return response()->json(['message' => 'Contrato no encontrado'], 404);
    }
}
