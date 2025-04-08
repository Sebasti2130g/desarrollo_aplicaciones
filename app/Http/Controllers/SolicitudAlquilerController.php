<?php

namespace App\Http\Controllers;

use App\Models\SolicitudAlquiler;
use Illuminate\Http\Request;

class SolicitudAlquilerController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/solicitud-alquiler",
     *     summary="Listar todas las solicitudes de alquiler",
     *     tags={"SolicitudAlquiler"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de solicitudes de alquiler",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/SolicitudAlquiler"))
     *     )
     * )
     */
    public function index()
    {
        $solicitudes = SolicitudAlquiler::with('usuario', 'apartamento')->get();
        return response()->json($solicitudes);
    }

    /**
     * @OA\Get(
     *     path="/api/solicitud-alquiler/create",
     *     summary="Mostrar formulario para crear solicitud de alquiler",
     *     tags={"SolicitudAlquiler"},
     *     @OA\Response(
     *         response=200,
     *         description="Formulario de creación de solicitud de alquiler",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Formulario de creación de solicitudes de alquiler")
     *         )
     *     )
     * )
     */
    public function create()
    {
        return response()->json(['message' => 'Formulario de creación de solicitudes de alquiler']);
    }

    /**
     * @OA\Post(
     *     path="/api/solicitud-alquiler",
     *     summary="Crear una nueva solicitud de alquiler",
     *     tags={"SolicitudAlquiler"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/SolicitudAlquiler")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Solicitud de alquiler creada",
     *         @OA\JsonContent(ref="#/components/schemas/SolicitudAlquiler")
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
            'usuario_id' => 'required|exists:usuario,id',
            'apartamento_id' => 'required|exists:apartamento,id',
            'fecha_solicitud' => 'required|date',
            'estado_solicitud' => 'required|string|max:255',
        ]);

        $solicitud = SolicitudAlquiler::create($request->all());
        return response()->json($solicitud, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/solicitud-alquiler/{id}",
     *     summary="Mostrar una solicitud de alquiler específica",
     *     tags={"SolicitudAlquiler"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la solicitud de alquiler",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Solicitud encontrada",
     *         @OA\JsonContent(ref="#/components/schemas/SolicitudAlquiler")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Solicitud de alquiler no encontrada"
     *     )
     * )
     */

    public function show($id)
    {
        $solicitud = SolicitudAlquiler::find($id);
        if ($solicitud) {
            return response()->json($solicitud);
        }
        return response()->json(['message' => 'Solicitud de alquiler no encontrada'], 404);
    }

    /**
     * @OA\Get(
     *     path="/api/solicitud-alquiler/{id}/edit",
     *     summary="Mostrar formulario para editar una solicitud de alquiler",
     *     tags={"SolicitudAlquiler"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la solicitud de alquiler",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Datos de la solicitud para editar",
     *         @OA\JsonContent(ref="#/components/schemas/SolicitudAlquiler")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Solicitud de alquiler no encontrada"
     *     )
     * )
     */
    public function edit($id)
    {
        $solicitud = SolicitudAlquiler::find($id);
        if ($solicitud) {
            return response()->json($solicitud);
        }
        return response()->json(['message' => 'Solicitud de alquiler no encontrada'], 404);
    }

    /**
     * @OA\Put(
     *     path="/api/solicitud-alquiler/{id}",
     *     summary="Actualizar una solicitud de alquiler",
     *     tags={"SolicitudAlquiler"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la solicitud",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/SolicitudAlquiler")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Solicitud de alquiler actualizada",
     *         @OA\JsonContent(ref="#/components/schemas/SolicitudAlquiler")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Solicitud de alquiler no encontrada"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $solicitud = SolicitudAlquiler::find($id);
        if ($solicitud) {
            $request->validate([
                'usuario_id' => 'required|exists:usuario,id',
                'apartamento_id' => 'required|exists:apartamento,id',
                'fecha_solicitud' => 'required|date',
                'estado_solicitud' => 'required|string|max:255',
            ]);

            $solicitud->update($request->all());
            return response()->json($solicitud);
        }
        return response()->json(['message' => 'Solicitud de alquiler no encontrada'], 404);
    }

    /**
     * @OA\Delete(
     *     path="/api/solicitud-alquiler/{id}",
     *     summary="Eliminar una solicitud de alquiler",
     *     tags={"SolicitudAlquiler"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la solicitud a eliminar",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Solicitud eliminada correctamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Solicitud de alquiler eliminada correctamente")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Solicitud de alquiler no encontrada"
     *     )
     * )
     */
    public function destroy($id)
    {
        $solicitud = SolicitudAlquiler::find($id);
        if ($solicitud) {
            $solicitud->delete();
            return response()->json(['message' => 'Solicitud de alquiler eliminada correctamente']);
        }
        return response()->json(['message' => 'Solicitud de alquiler no encontrada'], 404);
    }
}
