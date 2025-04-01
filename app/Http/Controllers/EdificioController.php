<?php

namespace App\Http\Controllers;

use App\Models\Edificio;
use Illuminate\Http\Request;

class EdificioController extends Controller
{
    /**
     * Muestra todos los edificios.
     */
    public function index()
    {
        $edificios = Edificio::all();
        return response()->json($edificios);
    }

    /**
     * Muestra un edificio específico.
     */
    public function show($id)
    {
        $edificio = Edificio::find($id);
        if ($edificio) {
            return response()->json($edificio);
        }
        return response()->json(['message' => 'Edificio no encontrado'], 404);
    }

    /**
     * Devuelve los datos necesarios para el formulario de creación de edificios.
     */
    public function create()
    {
        return response()->json(['message' => 'Formulario de creación de edificios']);
    }

    /**
     * Almacena un nuevo edificio en la base de datos.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255|unique:edificio,nombre',
            'direccion' => 'required|string|max:255',
        ]);

        $edificio = Edificio::create($validatedData);
        return response()->json($edificio, 201);
    }

    /**
     * Actualiza un edificio en la base de datos.
     */
    public function update(Request $request, $id)
    {
        $edificio = Edificio::find($id);
        if ($edificio) {
            $validatedData = $request->validate([
                'nombre' => 'required|string|max:255|unique:edificio,nombre,' . $id,
                'direccion' => 'required|string|max:255',
            ]);

            $edificio->update($validatedData);
            return response()->json($edificio);
        }
        return response()->json(['message' => 'Edificio no encontrado'], 404);
    }

    /**
     * Elimina un edificio de la base de datos.
     */
    public function destroy($id)
    {
        $edificio = Edificio::find($id);
        if ($edificio) {
            $edificio->delete();
            return response()->json(['message' => 'Edificio eliminado correctamente']);
        }
        return response()->json(['message' => 'Edificio no encontrado'], 404);
    }
}
