<?php

namespace App\Http\Controllers;

use App\Models\UsuarioRol;
use Illuminate\Http\Request;

class UsuarioRolController extends Controller
{
    /**
     * Mostrar todas las relaciones de usuario y rol.
     */
    public function index()
    {
        $usuarioRoles = UsuarioRol::with('usuario', 'rol')->get();
        return response()->json($usuarioRoles);
    }

    /**
     * Mostrar una relación específica de usuario y rol.
     */
    public function show($id)
    {
        $usuarioRol = UsuarioRol::find($id);
        if ($usuarioRol) {
            return response()->json($usuarioRol);
        }
        return response()->json(['message' => 'Relación de usuario y rol no encontrada'], 404);
    }

    /**
     * Método de creación (solo muestra un mensaje en la API).
     */
    public function create()
    {
        return response()->json(['message' => 'Formulario de creación de usuario-rol']);
    }

    /**
     * Almacenar una nueva relación usuario-rol.
     */
    public function store(Request $request)
    {
        $request->validate([
            'usuario_id' => 'required|exists:usuario,id',
            'rol_id' => 'required|exists:rol,id',
        ]);

        $usuarioRol = UsuarioRol::create($request->all());
        return response()->json($usuarioRol, 201);
    }

    /**
     * Actualizar una relación de usuario-rol existente.
     */
    public function update(Request $request, $id)
    {
        $usuarioRol = UsuarioRol::find($id);
        if ($usuarioRol) {
            $request->validate([
                'usuario_id' => 'required|exists:usuario,id',
                'rol_id' => 'required|exists:rol,id',
            ]);

            $usuarioRol->update($request->all());
            return response()->json($usuarioRol);
        }
        return response()->json(['message' => 'Relación de usuario y rol no encontrada'], 404);
    }

    /**
     * Eliminar una relación de usuario-rol.
     */
    public function destroy($id)
    {
        $usuarioRol = UsuarioRol::find($id);
        if ($usuarioRol) {
            $usuarioRol->delete();
            return response()->json(['message' => 'Relación de usuario y rol eliminada correctamente']);
        }
        return response()->json(['message' => 'Relación de usuario y rol no encontrada'], 404);
    }
}

