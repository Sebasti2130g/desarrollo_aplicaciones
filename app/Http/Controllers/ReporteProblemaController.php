<?php

namespace App\Http\Controllers;

use App\Models\ReporteProblema;
use Illuminate\Http\Request;

class ReporteProblemaController extends Controller
{
    /**
     * Muestra todos los reportes de problemas.
     */
    public function index()
    {
        $reportes = ReporteProblema::with('apartamento', 'usuario')->get();
        return response()->json($reportes);
    }

    /**
     * Devuelve los datos necesarios para el formulario de creación.
     */
    public function create()
    {
        return response()->json(['message' => 'Formulario de creación de reportes de problemas']);
    }

    /**
     * Almacena un nuevo reporte de problema.
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
     * Muestra un reporte de problema específico.
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
     * Devuelve los datos necesarios para el formulario de edición.
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
     * Actualiza un reporte de problema en la base de datos.
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
     * Elimina un reporte de problema de la base de datos.
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
