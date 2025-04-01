<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use Illuminate\Http\Request;

class RolController extends Controller
{
    /**
     * Muestra una lista de roles.
     */
    public function index()
    {
        return response()->json(Rol::all());
    }

    /**
     * Muestra un rol específico.
     */
    public function show(Rol $rol)
    {
        return response()->json($rol);
    }

    /**
     * Devuelve los datos necesarios para el formulario de creación.
     */
    public function create()
    {
        return response()->json(['message' => 'Formulario de creación de rol']);
    }

    /**
     * Almacena un nuevo rol en la base de datos.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255|unique:rol,nombre',
        ]);

        $rol = Rol::create($validatedData);

        return response()->json($rol, 201);
    }

    /**
     * Actualiza un rol en la base de datos.
     */
    public function update(Request $request, Rol $rol)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255|unique:rol,nombre,' . $rol->id,
        ]);

        $rol->update($validatedData);

        return response()->json($rol);
    }

    /**
     * Elimina un rol de la base de datos.
     */
    public function destroy(Rol $rol)
    {
        $rol->delete();
        return response()->json(['message' => 'Rol eliminado correctamente']);
    }
}
