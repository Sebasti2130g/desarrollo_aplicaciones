<?php

namespace App\Http\Controllers;

use App\Models\Apartamento;
use Illuminate\Http\Request;

class ApartamentoController extends Controller
{
    /**
     * Muestra todos los apartamentos.
     */
    public function index()
    {
        $apartamentos = Apartamento::all();
        return response()->json($apartamentos);
    }

    /**
     * Muestra un apartamento específico.
     */
    public function show($id)
    {
        $apartamento = Apartamento::find($id);
        if ($apartamento) {
            return response()->json($apartamento);
        }
        return response()->json(['message' => 'Apartamento no encontrado'], 404);
    }

    /**
     * Devuelve los datos necesarios para el formulario de creación de apartamentos.
     */
    public function create()
    {
        return response()->json(['message' => 'Formulario de creación de apartamentos']);
    }

    /**
     * Almacena un nuevo apartamento en la base de datos.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'usuario_id' => 'required|exists:usuario,id',
            'edificio_id' => 'required|exists:edificio,id',
            'numero_apartamento' => 'required|string|max:10|unique:apartamento,numero_apartamento',
            'piso' => 'required|integer|min:1',
            'precio' => 'required|numeric|min:0',
            'tamaño' => 'required|numeric|min:1',
        ]);

        $apartamento = Apartamento::create($validatedData);
        return response()->json($apartamento, 201);
    }

    /**
     * Actualiza un apartamento en la base de datos.
     */
    public function update(Request $request, $id)
    {
        $apartamento = Apartamento::find($id);
        if ($apartamento) {
            $validatedData = $request->validate([
                'usuario_id' => 'required|exists:usuario,id',
                'edificio_id' => 'required|exists:edificio,id',
                'numero_apartamento' => 'required|string|max:10|unique:apartamento,numero_apartamento,' . $id,
                'piso' => 'required|integer|min:1',
                'precio' => 'required|numeric|min:0',
                'tamaño' => 'required|numeric|min:1',
            ]);

            $apartamento->update($validatedData);
            return response()->json($apartamento);
        }
        return response()->json(['message' => 'Apartamento no encontrado'], 404);
    }

    /**
     * Elimina un apartamento de la base de datos.
     */
    public function destroy($id)
    {
        $apartamento = Apartamento::find($id);
        if ($apartamento) {
            $apartamento->delete();
            return response()->json(['message' => 'Apartamento eliminado correctamente']);
        }
        return response()->json(['message' => 'Apartamento no encontrado'], 404);
    }
}
