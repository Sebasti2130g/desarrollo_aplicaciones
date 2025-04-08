<?php

namespace App\Http\Controllers;

use App\Models\Edificio;
use Illuminate\Http\Request;

class EdificioController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/edificio",
     *     tags={"Edificio"},
     *     summary="Listar todos los edificios",
     *     @OA\Response(
     *         response=200,
     *         description="Lista de edificios",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Edificio"))
     *     )
     * )
     */
    public function index()
    {
        $edificios = Edificio::all();
        return response()->json($edificios);
    }

    /**
     * @OA\Get(
     *     path="/api/edificio/{id}",
     *     tags={"Edificio"},
     *     summary="Obtener un edificio específico",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del edificio",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Edificio encontrado",
     *         @OA\JsonContent(ref="#/components/schemas/Edificio")
     *     ),
     *     @OA\Response(response=404, description="Edificio no encontrado")
     * )
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
     * @OA\Get(
     *     path="/api/edificio/create",
     *     tags={"Edificio"},
     *     summary="Obtener datos para el formulario de creación de edificios",
     *     description="Devuelve un mensaje indicando que se debe mostrar el formulario de creación de edificios (útil como placeholder o para pruebas).",
     *     @OA\Response(
     *         response=200,
     *         description="Formulario de creación de edificios",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Formulario de creación de edificios")
     *         )
     *     )
     * )
     */
    public function create()
    {
        return response()->json(['message' => 'Formulario de creación de edificios']);
    }

    /**
     * @OA\Post(
     *     path="/api/edificio",
     *     tags={"Edificio"},
     *     summary="Crear un nuevo edificio",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nombre","direccion"},
     *             @OA\Property(property="nombre", type="string", example="Torre Central"),
     *             @OA\Property(property="direccion", type="string", example="Calle 123 #45-67"),
     *             @OA\Property(property="cantidad_pisos", type="integer", example=10)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Edificio creado exitosamente",
     *         @OA\JsonContent(ref="#/components/schemas/Edificio")
     *     ),
     *     @OA\Response(response=422, description="Datos inválidos")
     * )
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
     * @OA\Put(
     *     path="/api/edificio/{id}",
     *     tags={"Edificio"},
     *     summary="Actualizar un edificio existente",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del edificio",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nombre","direccion"},
     *             @OA\Property(property="nombre", type="string", example="Torre Sur"),
     *             @OA\Property(property="direccion", type="string", example="Avenida 10 #23-45"),
     *             @OA\Property(property="cantidad_pisos", type="integer", example=8)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Edificio actualizado correctamente",
     *         @OA\JsonContent(ref="#/components/schemas/Edificio")
     *     ),
     *     @OA\Response(response=404, description="Edificio no encontrado"),
     *     @OA\Response(response=422, description="Datos inválidos")
     * )
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
     * @OA\Delete(
     *     path="/api/edificio/{id}",
     *     tags={"Edificio"},
     *     summary="Eliminar un edificio",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del edificio a eliminar",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Edificio eliminado correctamente"),
     *     @OA\Response(response=404, description="Edificio no encontrado")
     * )
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
