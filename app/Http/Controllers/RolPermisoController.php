<?php

namespace App\Http\Controllers;

use App\Models\RolPermiso;
use Illuminate\Http\Request;

class RolPermisoController extends Controller
{
    /**
     * Mostrar todas las relaciones de rol y permiso.
     */
    public function index()
    {
        $rolPermisos = RolPermiso::with('rol', 'permiso')->get();
        return response()->json($rolPermisos);
    }

    /**
     * Mostrar una relación específica de rol y permiso.
     */
    public function show($id)
    {
        $rolPermiso = RolPermiso::find($id);
        if ($rolPermiso) {
            return response()->json($rolPermiso);
        }
        return response()->json(['message' => 'Relación de rol y permiso no encontrada'], 404);
    }

    /**
     * Método de creación (solo muestra un mensaje en la API).
     */
    public function create()
    {
        return response()->json(['message' => 'Formulario de creación de rol-permiso']);
    }

    /**
     * Almacenar una nueva relación rol-permiso.
     */
    public function store(Request $request)
    {
        $request->validate([
            'rol_id' => 'required|exists:rol,id',
            'permiso_id' => 'required|exists:permiso,id',
        ]);

        $rolPermiso = RolPermiso::create($request->all());
        return response()->json($rolPermiso, 201);
    }

    /**
     * Actualizar una relación de rol-permiso existente.
     */
    public function update(Request $request, $id)
    {
        $rolPermiso = RolPermiso::find($id);
        if ($rolPermiso) {
            $request->validate([
                'rol_id' => 'required|exists:rol,id',
                'permiso_id' => 'required|exists:permiso,id',
            ]);

            $rolPermiso->update($request->all());
            return response()->json($rolPermiso);
        }
        return response()->json(['message' => 'Relación de rol y permiso no encontrada'], 404);
    }

    /**
     * Eliminar una relación de rol-permiso.
     */
    public function destroy($id)
    {
        $rolPermiso = RolPermiso::find($id);
        if ($rolPermiso) {
            $rolPermiso->delete();
            return response()->json(['message' => 'Relación de rol y permiso eliminada correctamente']);
        }
        return response()->json(['message' => 'Relación de rol y permiso no encontrada'], 404);
    }
}
