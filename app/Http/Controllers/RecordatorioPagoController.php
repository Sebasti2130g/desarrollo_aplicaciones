<?php

namespace App\Http\Controllers;

use App\Models\RecordatorioPago;
use Illuminate\Http\Request;

class RecordatorioPagoController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/recordatorio-pago",
     *     summary="Listar todos los recordatorios de pago",
     *     tags={"RecordatorioPago"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de recordatorios de pago",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/RecordatorioPago"))
     *     )
     * )
     */
    public function index()
    {
        $recordatorios = RecordatorioPago::with('usuario')->get();
        return response()->json($recordatorios);
    }

   /**
     * @OA\Get(
     *     path="/api/recordatorio-pago/create",
     *     summary="Formulario de creación de recordatorios de pago",
     *     tags={"RecordatorioPago"},
     *     @OA\Response(
     *         response=200,
     *         description="Formulario de creación"
     *     )
     * )
     */
    public function create()
    {
        return response()->json(['message' => 'Formulario de creación de recordatorios de pago']);
    }

    /**
     * @OA\Post(
     *     path="/api/recordatorio-pago",
     *     summary="Crear un nuevo recordatorio de pago",
     *     tags={"RecordatorioPago"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"usuario_id", "medio", "fecha_envio"},
     *             @OA\Property(property="usuario_id", type="integer", example=1),
     *             @OA\Property(property="medio", type="string", example="Correo electrónico"),
     *             @OA\Property(property="fecha_envio", type="string", format="date", example="2025-04-08")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Recordatorio de pago creado"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'usuario_id' => 'required|exists:usuario,id',
            'medio' => 'required|string|max:255',
            'fecha_envio' => 'required|date',
        ]);

        $recordatorio = RecordatorioPago::create($request->all());
        return response()->json($recordatorio, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/recordatorio-pago/{id}",
     *     summary="Obtener un recordatorio de pago específico",
     *     tags={"RecordatorioPago"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Recordatorio de pago encontrado",
     *         @OA\JsonContent(ref="#/components/schemas/RecordatorioPago")
     *     ),
     *     @OA\Response(response=404, description="Recordatorio de pago no encontrado")
     * )
     */
    public function show($id)
    {
        $recordatorio = RecordatorioPago::find($id);
        if ($recordatorio) {
            return response()->json($recordatorio);
        }
        return response()->json(['message' => 'Recordatorio de pago no encontrado'], 404);
    }

    /**
     * @OA\Get(
     *     path="/api/recordatorio-pago/{id}/edit",
     *     summary="Formulario de edición de recordatorio de pago",
     *     tags={"RecordatorioPago"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Formulario de edición"
     *     ),
     *     @OA\Response(response=404, description="Recordatorio de pago no encontrado")
     * )
     */
    public function edit($id)
    {
        $recordatorio = RecordatorioPago::find($id);
        if ($recordatorio) {
            return response()->json($recordatorio);
        }
        return response()->json(['message' => 'Recordatorio de pago no encontrado'], 404);
    }

    /**
     * @OA\Put(
     *     path="/api/recordatorio-pago/{id}",
     *     summary="Actualizar un recordatorio de pago",
     *     tags={"RecordatorioPago"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"usuario_id", "medio", "fecha_envio"},
     *             @OA\Property(property="usuario_id", type="integer", example=1),
     *             @OA\Property(property="medio", type="string", example="SMS"),
     *             @OA\Property(property="fecha_envio", type="string", format="date", example="2025-04-10")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Recordatorio actualizado"),
     *     @OA\Response(response=404, description="Recordatorio no encontrado")
     * )
     */
    public function update(Request $request, $id)
    {
        $recordatorio = RecordatorioPago::find($id);
        if ($recordatorio) {
            $request->validate([
                'usuario_id' => 'required|exists:usuario,id',
                'medio' => 'required|string|max:255',
                'fecha_envio' => 'required|date',
            ]);

            $recordatorio->update($request->all());
            return response()->json($recordatorio);
        }
        return response()->json(['message' => 'Recordatorio de pago no encontrado'], 404);
    }

    /**
     * @OA\Delete(
     *     path="/api/recordatorio-pago/{id}",
     *     summary="Eliminar un recordatorio de pago",
     *     tags={"RecordatorioPago"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Recordatorio eliminado"),
     *     @OA\Response(response=404, description="Recordatorio no encontrado")
     * )
     */
    public function destroy($id)
    {
        $recordatorio = RecordatorioPago::find($id);
        if ($recordatorio) {
            $recordatorio->delete();
            return response()->json(['message' => 'Recordatorio de pago eliminado correctamente']);
        }
        return response()->json(['message' => 'Recordatorio de pago no encontrado'], 404);
    }
}
