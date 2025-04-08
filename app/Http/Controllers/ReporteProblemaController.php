<?php

namespace App\Http\Controllers;

use App\Models\ReporteProblema;
use Illuminate\Http\Request;

class ReporteProblemaController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/reporte-problema",
     *     summary="Listar todos los reportes de problemas",
     *     tags={"ReporteProblema"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de reportes de problemas",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/ReporteProblema"))
     *     )
     * )
     */
    public function index()
    {
        $reportes = ReporteProblema::with('apartamento', 'usuario')->get();
        return response()->json($reportes);
    }

    /**
     * @OA\Get(
     *     path="/api/reporte-problema/create",
     *     summary="Formulario de creación de reportes de problemas",
     *     tags={"ReporteProblema"},
     *     @OA\Response(
     *         response=200,
     *         description="Formulario de creación"
     *     )
     * )
     */
    public function create()
    {
        return response()->json(['message' => 'Formulario de creación de reportes de problemas']);
    }

    /**
     * @OA\Post(
     *     path="/api/reporte-problema",
     *     summary="Crear un nuevo reporte de problema",
     *     tags={"ReporteProblema"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"apartamento_id", "usuario_id", "descripcion", "estado", "fecha_reporte"},
     *             @OA\Property(property="apartamento_id", type="integer", example=1),
     *             @OA\Property(property="usuario_id", type="integer", example=2),
     *             @OA\Property(property="descripcion", type="string", example="Grieta en la pared"),
     *             @OA\Property(property="estado", type="string", example="pendiente"),
     *             @OA\Property(property="fecha_reporte", type="string", format="date", example="2025-04-08")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Reporte de problema creado"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'apartamento_id' => 'required|exists:apartamento,id',
            'usuario_id' => 'required|exists:usuario,id',
            'descripcion' => 'required|string|max:500',
            'estado' => 'required|string|in:pendiente,atendido,cerrado',
            'fecha_reporte' => 'required|date',
        ]);

        $reporte = ReporteProblema::create($request->all());
        return response()->json($reporte, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/reporte-problema/{id}",
     *     summary="Obtener un reporte de problema específico",
     *     tags={"ReporteProblema"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Reporte de problema encontrado",
     *         @OA\JsonContent(ref="#/components/schemas/ReporteProblema")
     *     ),
     *     @OA\Response(response=404, description="Reporte de problema no encontrado")
     * )
     */
    public function show($id)
    {
        $reporte = ReporteProblema::find($id);
        if ($reporte) {
            return response()->json($reporte);
        }
        return response()->json(['message' => 'Reporte de problema no encontrado'], 404);
    }

    /**
     * @OA\Get(
     *     path="/api/reporte-problema/{id}/edit",
     *     summary="Formulario de edición de reporte de problema",
     *     tags={"ReporteProblema"},
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
     *     @OA\Response(response=404, description="Reporte de problema no encontrado")
     * )
     */
    public function edit($id)
    {
        $reporte = ReporteProblema::find($id);
        if ($reporte) {
            return response()->json($reporte);
        }
        return response()->json(['message' => 'Reporte de problema no encontrado'], 404);
    }

    /**
     * @OA\Put(
     *     path="/api/reporte-problema/{id}",
     *     summary="Actualizar un reporte de problema",
     *     tags={"ReporteProblema"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"apartamento_id", "usuario_id", "descripcion", "estado", "fecha_reporte"},
     *             @OA\Property(property="apartamento_id", type="integer", example=1),
     *             @OA\Property(property="usuario_id", type="integer", example=2),
     *             @OA\Property(property="descripcion", type="string", example="Fuga en la cocina"),
     *             @OA\Property(property="estado", type="string", example="atendido"),
     *             @OA\Property(property="fecha_reporte", type="string", format="date", example="2025-04-09")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Reporte actualizado correctamente"
     *     ),
     *     @OA\Response(response=404, description="Reporte no encontrado")
     * )
     */
    public function update(Request $request, $id)
    {
        $reporte = ReporteProblema::find($id);
        if ($reporte) {
            $request->validate([
                'apartamento_id' => 'required|exists:apartamento,id',
                'usuario_id' => 'required|exists:usuario,id',
                'descripcion' => 'required|string|max:500',
                'estado' => 'required|string|in:pendiente,atendido,cerrado',
                'fecha_reporte' => 'required|date',
            ]);

            $reporte->update($request->all());
            return response()->json($reporte);
        }
        return response()->json(['message' => 'Reporte de problema no encontrado'], 404);
    }

    /**
     * @OA\Delete(
     *     path="/api/reporte-problema/{id}",
     *     summary="Eliminar un reporte de problema",
     *     tags={"ReporteProblema"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Reporte de problema eliminado"),
     *     @OA\Response(response=404, description="Reporte de problema no encontrado")
     * )
     */
    public function destroy($id)
    {
        $reporte = ReporteProblema::find($id);
        if ($reporte) {
            $reporte->delete();
            return response()->json(['message' => 'Reporte de problema eliminado correctamente']);
        }
        return response()->json(['message' => 'Reporte de problema no encontrado'], 404);
    }
}
