<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{

    /**
     * @OA\Get(
     *     path="/api/usuarios",
     *     summary="Listar todos los usuarios",
     *     tags={"Usuario"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de usuarios obtenida correctamente"
     *     )
     * )
     */
    public function index()
    {
        $usuarios = Usuario::all();
        return response()->json($usuarios);
    }

    /**
     * @OA\Get(
     *     path="/api/usuarios/create",
     *     summary="Mostrar mensaje de formulario de creación de usuario (solo informativo)",
     *     tags={"Usuario"},
     *     @OA\Response(
     *         response=200,
     *         description="Mensaje informativo sobre el formulario de creación"
     *     )
     * )
     */
    public function create()
    {
        return response()->json(['message' => 'Formulario de creación de usuario']);
    }

    /**
     * @OA\Post(
     *     path="/api/usuarios",
     *     summary="Crear un nuevo usuario",
     *     tags={"Usuario"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nombre", "correo", "telefono", "contraseña"},
     *             @OA\Property(property="nombre", type="string", example="Juan Pérez"),
     *             @OA\Property(property="correo", type="string", format="email", example="juan@example.com"),
     *             @OA\Property(property="telefono", type="string", example="3012345678"),
     *             @OA\Property(property="contraseña", type="string", format="password", example="secreto123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Usuario creado exitosamente",
     *         @OA\JsonContent(ref="#/components/schemas/Usuario")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Errores de validación"
     *     )
     * )
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
     * @OA\Get(
     *     path="/api/usuarios/{id}",
     *     summary="Mostrar información de un usuario específico",
     *     tags={"Usuario"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del usuario",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Usuario encontrado",
     *         @OA\JsonContent(ref="#/components/schemas/Usuario")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Usuario no encontrado"
     *     )
     * )
     */
    public function show(Usuario $usuario)
    {
        return response()->json($usuario);
    }

    /**
     * @OA\Get(
     *     path="/api/usuarios/{id}/edit",
     *     summary="Obtener datos para editar un usuario",
     *     tags={"Usuario"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del usuario",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Datos del usuario para edición",
     *         @OA\JsonContent(ref="#/components/schemas/Usuario")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Usuario no encontrado"
     *     )
     * )
     */
    public function edit(Usuario $usuario)
    {
        return response()->json($usuario);
    }

    /**
     * @OA\Put(
     *     path="/api/usuarios/{id}",
     *     summary="Actualizar un usuario existente",
     *     tags={"Usuario"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del usuario a actualizar",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nombre", "correo", "telefono"},
     *             @OA\Property(property="nombre", type="string", example="Juan Pérez"),
     *             @OA\Property(property="correo", type="string", format="email", example="juan@example.com"),
     *             @OA\Property(property="telefono", type="string", example="3012345678"),
     *             @OA\Property(property="contraseña", type="string", format="password", example="nuevaClave123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Usuario actualizado correctamente",
     *         @OA\JsonContent(ref="#/components/schemas/Usuario")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Errores de validación"
     *     )
     * )
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
     * @OA\Delete(
     *     path="/api/usuarios/{id}",
     *     summary="Eliminar un usuario",
     *     tags={"Usuario"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del usuario a eliminar",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Usuario eliminado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Usuario eliminado")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Usuario no encontrado"
     *     )
     * )
     */
    public function destroy(Usuario $usuario)
    {
        $usuario->delete();
        return response()->json(['message' => 'Usuario eliminado']);
    }
}
