<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    /**
     * Muestra una lista de usuarios.
     */
    public function index()
    {
        $usuarios = Usuario::all();
        return response()->json($usuarios);
    }

    /**
     * Devuelve los datos necesarios para el formulario de creación.
     */
    public function create()
    {
        return response()->json(['message' => 'Formulario de creación de usuario']);
    }

    /**
     * Almacena un nuevo usuario en la base de datos.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'correo' => 'required|email|unique:usuario,correo',
            'telefono' => 'required|string|max:20',
            'contraseña' => 'required|string|min:8',
        ]);

        $usuario = Usuario::create($validatedData);

        return response()->json($usuario, 201);
    }

    /**
     * Muestra un usuario específico.
     */
    public function show(Usuario $usuario)
    {
        return response()->json($usuario);
    }

    /**
     * Devuelve los datos necesarios para el formulario de edición.
     */
    public function edit(Usuario $usuario)
    {
        return response()->json($usuario);
    }

    /**
     * Actualiza un usuario en la base de datos.
     */
    public function update(Request $request, Usuario $usuario)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'correo' => 'required|email|unique:usuario,correo,' . $usuario->id,
            'telefono' => 'required|string|max:20',
            'contraseña' => 'nullable|string|min:8',
        ]);

        $usuario->update($validatedData);

        return response()->json($usuario);
    }

    /**
     * Elimina un usuario de la base de datos.
     */
    public function destroy(Usuario $usuario)
    {
        $usuario->delete();
        return response()->json(['message' => 'Usuario eliminado']);
    }
}
