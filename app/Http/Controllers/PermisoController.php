<?php

namespace App\Http\Controllers;

use App\Models\Permiso;
use Illuminate\Http\Request;

class PermisoController extends Controller
{
    /**
     * Muestra una lista de permisos.
     */
    public function index()
    {
        $permisos = Permiso::all();
        return response()->json($permisos);
    }

    /**
     * Devuelve los datos necesarios para el formulario de creación.
     */
    public function create()
    {
        return response()->json(['message' => 'Formulario de creación de permisos']);
    }

    /**
     * Almacena un nuevo permiso en la base de datos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:permiso',
        ]);

        $permiso = Permiso::create($request->all());
        return response()->json($permiso, 201);
    }

    /**
     * Muestra un permiso específico.
     */
    public function show(Permiso $permiso)
    {
        return response()->json($permiso);
    }

    /**
     * Devuelve los datos necesarios para el formulario de edición.
     */
    public function edit(Permiso $permiso)
    {
        return response()->json($permiso);
    }

    /**
     * Actualiza un permiso en la base de datos.
     */
    public function update(Request $request, Permiso $permiso)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:permiso,nombre,' . $permiso->id,
        ]);

        $permiso->update($request->all());
        return response()->json($permiso);
    }

    /**
     * Elimina un permiso de la base de datos.
     */
    public function destroy(Permiso $permiso)
    {
        $permiso->delete();
        return response()->json(['message' => 'Permiso eliminado']);
    }
}
