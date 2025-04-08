<?php

namespace App\Http\Controllers;

use App\Models\Evaluacion;
use Illuminate\Http\Request;

class EvaluacionController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/evaluaciones",
     *     summary="Listar todas las evaluaciones",
     *     tags={"Evaluacion"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de evaluaciones"
     *     )
     * )
     */
    public function index()
    {
        $evaluaciones = Evaluacion::with('usuario', 'apartamento')->get();
        return response()->json($evaluaciones);
    }

    /**
     * @OA\Get(
     *     path="/api/evaluaciones/create",
     *     summary="Formulario para crear una evaluación",
     *     tags={"Evaluacion"},
     *     @OA\Response(
     *         response=200,
     *         description="Mensaje para formulario de creación"
     *     )
     * )
     */
    public function create()
    {
        return response()->json(['message' => 'Formulario de creación de evaluaciones']);
    }

    /**
     * @OA\Post(
     *     path="/api/evaluaciones",
     *     summary="Crear una nueva evaluación",
     *     tags={"Evaluacion"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"usuario_id", "apartamento_id", "calificacion", "fecha_evaluacion"},
     *             @OA\Property(property="usuario_id", type="integer"),
     *             @OA\Property(property="apartamento_id", type="integer"),
     *             @OA\Property(property="calificacion", type="integer", minimum=1, maximum=5),
     *             @OA\Property(property="comentario", type="string"),
     *             @OA\Property(property="fecha_evaluacion", type="string", format="date")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Evaluación creada exitosamente"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'usuario_id' => 'required|exists:usuario,id',
            'apartamento_id' => 'required|exists:apartamento,id',
            'calificacion' => 'required|integer|min:1|max:5',
            'comentario' => 'nullable|string|max:500',
            'fecha_evaluacion' => 'required|date',
        ]);

        $evaluacion = Evaluacion::create($request->all());
        return response()->json($evaluacion, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/evaluaciones/{id}",
     *     summary="Mostrar una evaluación específica",
     *     tags={"Evaluacion"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Evaluación encontrada"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Evaluación no encontrada"
     *     )
     * )
     */
    public function show($id)
    {
        $evaluacion = Evaluacion::find($id);
        if ($evaluacion) {
            return response()->json($evaluacion);
        }
        return response()->json(['message' => 'Evaluación no encontrada'], 404);
    }

    /**
     * @OA\Get(
     *     path="/api/evaluaciones/{id}/edit",
     *     summary="Formulario para editar una evaluación",
     *     tags={"Evaluacion"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Datos de la evaluación"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Evaluación no encontrada"
     *     )
     * )
     */
    public function edit($id)
    {
        $evaluacion = Evaluacion::find($id);
        if ($evaluacion) {
            return response()->json($evaluacion);
        }
        return response()->json(['message' => 'Evaluación no encontrada'], 404);
    }

    /**
     * @OA\Put(
     *     path="/api/evaluaciones/{id}",
     *     summary="Actualizar una evaluación",
     *     tags={"Evaluacion"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"usuario_id", "apartamento_id", "calificacion", "fecha_evaluacion"},
     *             @OA\Property(property="usuario_id", type="integer"),
     *             @OA\Property(property="apartamento_id", type="integer"),
     *             @OA\Property(property="calificacion", type="integer", minimum=1, maximum=5),
     *             @OA\Property(property="comentario", type="string"),
     *             @OA\Property(property="fecha_evaluacion", type="string", format="date")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Evaluación actualizada correctamente"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Evaluación no encontrada"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $evaluacion = Evaluacion::find($id);
        if ($evaluacion) {
            $request->validate([
                'usuario_id' => 'required|exists:usuario,id',
                'apartamento_id' => 'required|exists:apartamento,id',
                'calificacion' => 'required|integer|min:1|max:5',
                'comentario' => 'nullable|string|max:500',
                'fecha_evaluacion' => 'required|date',
            ]);

            $evaluacion->update($request->all());
            return response()->json($evaluacion);
        }
        return response()->json(['message' => 'Evaluación no encontrada'], 404);
    }

    /**
     * @OA\Delete(
     *     path="/api/evaluaciones/{id}",
     *     summary="Eliminar una evaluación",
     *     tags={"Evaluacion"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Evaluación eliminada correctamente"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Evaluación no encontrada"
     *     )
     * )
     */
    public function destroy($id)
    {
        $evaluacion = Evaluacion::find($id);
        if ($evaluacion) {
            $evaluacion->delete();
            return response()->json(['message' => 'Evaluación eliminada correctamente']);
        }
        return response()->json(['message' => 'Evaluación no encontrada'], 404);
    }
}
