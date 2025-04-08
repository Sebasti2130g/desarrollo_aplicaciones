<?php

namespace App\Http\Controllers;

use App\Models\Contrato;
use Illuminate\Http\Request;

class ContratoController extends Controller
{
    /**
     * @OA\Get(
     *     path="/contratos",
     *     tags={"Contratos"},
     *     summary="Lista todos los contratos",
     *     @OA\Response(
     *         response=200,
     *         description="Lista de contratos",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Contrato"))
     *     )
     * )
     */
    public function index()
    {
        $contratos = Contrato::with('usuario', 'apartamento')->get();
        return response()->json($contratos);
    }

    /**
     * @OA\Get(
     *     path="/contratos/{id}",
     *     tags={"Contratos"},
     *     summary="Muestra un contrato específico",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Contrato encontrado",
     *         @OA\JsonContent(ref="#/components/schemas/Contrato")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Contrato no encontrado"
     *     )
     * )
     */

    public function show($id)
    {
        $contrato = Contrato::with('usuario', 'apartamento')->find($id);
        if ($contrato) {
            return response()->json($contrato);
        }
        return response()->json(['message' => 'Contrato no encontrado'], 404);
    }

        /**
     * @OA\Get(
     *     path="/contratos/create",
     *     tags={"Contratos"},
     *     summary="Devuelve datos para el formulario de creación de contrato",
     *     @OA\Response(
     *         response=200,
     *         description="Formulario de creación de contratos"
     *     )
     * )
     */
    public function create()
    {
        return response()->json(['message' => 'Formulario de creación de contratos']);
    }

    /**
     * @OA\Post(
     *     path="/contratos",
     *     tags={"Contratos"},
     *     summary="Crea un nuevo contrato",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Contrato")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Contrato creado correctamente",
     *         @OA\JsonContent(ref="#/components/schemas/Contrato")
     *     )
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'usuario_id' => 'required|exists:usuario,id',
            'apartamento_id' => 'required|exists:apartamento,id',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date',
            'firma_digital' => 'required|string',
        ]);

        $contrato = Contrato::create($request->all());
        return response()->json($contrato, 201);
    }

    /**
     * @OA\Put(
     *     path="/contratos/{id}",
     *     tags={"Contratos"},
     *     summary="Actualiza un contrato existente",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Contrato")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Contrato actualizado",
     *         @OA\JsonContent(ref="#/components/schemas/Contrato")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Contrato no encontrado"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $contrato = Contrato::find($id);
        if ($contrato) {
            $request->validate([
                'usuario_id' => 'required|exists:usuario,id',
                'apartamento_id' => 'required|exists:apartamento,id',
                'fecha_inicio' => 'required|date',
                'fecha_fin' => 'required|date',
                'firma_digital' => 'required|string',
            ]);

            $contrato->update($request->all());
            return response()->json($contrato);
        }
        return response()->json(['message' => 'Contrato no encontrado'], 404);
    }

    /**
     * @OA\Delete(
     *     path="/contratos/{id}",
     *     tags={"Contratos"},
     *     summary="Elimina un contrato",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Contrato eliminado correctamente"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Contrato no encontrado"
     *     )
     * )
     */
    public function destroy($id)
    {
        $contrato = Contrato::find($id);
        if ($contrato) {
            $contrato->delete();
            return response()->json(['message' => 'Contrato eliminado correctamente']);
        }
        return response()->json(['message' => 'Contrato no encontrado'], 404);
    }
}
