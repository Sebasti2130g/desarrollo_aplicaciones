<?php

namespace App\Http\Controllers;

use App\Models\EstadoAlquiler;
use Illuminate\Http\Request;

class EstadoAlquilerController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/estado_alquiler",
     *     summary="Mostrar todos los estados de alquiler",
     *     tags={"EstadoAlquiler"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de estados de alquiler"
     *     )
     * )
     */
    public function index()
    {
        $estadosAlquiler = EstadoAlquiler::with('contrato', 'usuario')->get();
        return response()->json($estadosAlquiler);
    }

    /**
     * @OA\Get(
     *     path="/api/estado_alquiler/{id}",
     *     summary="Mostrar un estado de alquiler específico",
     *     tags={"EstadoAlquiler"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del estado de alquiler",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Estado de alquiler encontrado"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Estado de alquiler no encontrado"
     *     )
     * )
     */
    public function show($id)
    {
        $estadoAlquiler = EstadoAlquiler::with('contrato', 'usuario')->find($id);
        if ($estadoAlquiler) {
            return response()->json($estadoAlquiler);
        }
        return response()->json(['message' => 'Estado de alquiler no encontrado'], 404);
    }

    /**
     * @OA\Get(
     *     path="/api/estado_alquiler/create",
     *     summary="Obtener formulario de creación de estado de alquiler",
     *     tags={"EstadoAlquiler"},
     *     @OA\Response(
     *         response=200,
     *         description="Formulario de creación de estado de alquiler"
     *     )
     * )
     */
    public function create()
    {
        return response()->json(['message' => 'Formulario de creación de estado de alquiler']);
    }

    /**
     * @OA\Post(
     *     path="/api/estado_alquiler",
     *     summary="Crear un nuevo estado de alquiler",
     *     tags={"EstadoAlquiler"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"contrato_id","usuario_id","estado","fecha_reporte"},
     *             @OA\Property(property="contrato_id", type="integer", example=1),
     *             @OA\Property(property="usuario_id", type="integer", example=2),
     *             @OA\Property(property="estado", type="string", example="Pagado"),
     *             @OA\Property(property="fecha_reporte", type="string", format="date", example="2025-04-01")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Estado de alquiler creado exitosamente"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error de validación"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'contrato_id' => 'required|exists:contrato,id',
            'usuario_id' => 'required|exists:usuario,id',
            'estado' => 'required|string|max:255',
            'fecha_reporte' => 'required|date',
        ]);

        $estadoAlquiler = EstadoAlquiler::create($request->all());
        return response()->json($estadoAlquiler, 201);
    }

    /**
     * @OA\Put(
     *     path="/api/estado_alquiler/{id}",
     *     summary="Actualizar un estado de alquiler existente",
     *     tags={"EstadoAlquiler"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del estado de alquiler",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"contrato_id","usuario_id","estado","fecha_reporte"},
     *             @OA\Property(property="contrato_id", type="integer", example=1),
     *             @OA\Property(property="usuario_id", type="integer", example=2),
     *             @OA\Property(property="estado", type="string", example="Vencido"),
     *             @OA\Property(property="fecha_reporte", type="string", format="date", example="2025-04-05")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Estado de alquiler actualizado correctamente"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Estado de alquiler no encontrado"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $estadoAlquiler = EstadoAlquiler::find($id);
        if ($estadoAlquiler) {
            $request->validate([
                'contrato_id' => 'required|exists:contrato,id',
                'usuario_id' => 'required|exists:usuario,id',
                'estado' => 'required|string|max:255',
                'fecha_reporte' => 'required|date',
            ]);

            $estadoAlquiler->update($request->all());
            return response()->json($estadoAlquiler);
        }
        return response()->json(['message' => 'Estado de alquiler no encontrado'], 404);
    }

    /**
     * @OA\Delete(
     *     path="/api/estado_alquiler/{id}",
     *     summary="Eliminar un estado de alquiler",
     *     tags={"EstadoAlquiler"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del estado de alquiler",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Estado de alquiler eliminado correctamente"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Estado de alquiler no encontrado"
     *     )
     * )
     */
    public function destroy($id)
    {
        $estadoAlquiler = EstadoAlquiler::find($id);
        if ($estadoAlquiler) {
            $estadoAlquiler->delete();
            return response()->json(['message' => 'Estado de alquiler eliminado correctamente']);
        }
        return response()->json(['message' => 'Estado de alquiler no encontrado'], 404);
    }
}
