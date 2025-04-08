<?php

namespace App\Http\Controllers;

use App\Models\Apartamento;
use Illuminate\Http\Request;

class ApartamentoController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/apartamentos",
     *     summary="Listar todos los apartamentos",
     *     tags={"Apartamento"},
     *     @OA\Response(response=200, description="Lista de apartamentos")
     * )
     */
    public function index()
    {
        $apartamentos = Apartamento::all();
        return response()->json($apartamentos);
    }

    /**
     * @OA\Get(
     *     path="/api/apartamentos/{id}",
     *     summary="Mostrar un apartamento específico",
     *     tags={"Apartamento"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Datos del apartamento"),
     *     @OA\Response(response=404, description="Apartamento no encontrado")
     * )
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
     * @OA\Get(
     *     path="/api/apartamentos/create",
     *     summary="Obtener formulario para crear apartamento",
     *     tags={"Apartamento"},
     *     @OA\Response(response=200, description="Formulario de creación de apartamentos")
     * )
     */
    public function create()
    {
        return response()->json(['message' => 'Formulario de creación de apartamentos']);
    }

    /**
     * @OA\Post(
     *     path="/api/apartamentos",
     *     summary="Crear un nuevo apartamento",
     *     tags={"Apartamento"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Apartamento")
     *     ),
     *     @OA\Response(response=201, description="Apartamento creado correctamente"),
     *     @OA\Response(response=422, description="Errores de validación")
     * )
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
     * @OA\Put(
     *     path="/api/apartamentos/{id}",
     *     summary="Actualizar un apartamento",
     *     tags={"Apartamento"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Apartamento")
     *     ),
     *     @OA\Response(response=200, description="Apartamento actualizado correctamente"),
     *     @OA\Response(response=404, description="Apartamento no encontrado")
     * )
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
     * @OA\Delete(
     *     path="/api/apartamentos/{id}",
     *     summary="Eliminar un apartamento",
     *     tags={"Apartamento"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Apartamento eliminado correctamente"),
     *     @OA\Response(response=404, description="Apartamento no encontrado")
     * )
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
