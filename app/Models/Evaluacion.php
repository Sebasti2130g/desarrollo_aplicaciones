<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Evaluacion",
 *     type="object",
 *     title="Evaluacion",
 *     required={"usuario_id", "apartamento_id", "calificacion", "fecha_evaluacion"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="usuario_id", type="integer", example=3),
 *     @OA\Property(property="apartamento_id", type="integer", example=2),
 *     @OA\Property(property="calificacion", type="integer", format="int32", example=5),
 *     @OA\Property(property="comentario", type="string", example="Muy buen apartamento, limpio y bien ubicado."),
 *     @OA\Property(property="fecha_evaluacion", type="string", format="date", example="2025-04-08")
 * )
 */

class Evaluacion extends Model
{
    use HasFactory;

    protected $table = 'evaluacion';
    protected $fillable = ['usuario_id', 'apartamento_id', 'calificacion', 'comentario', 'fecha_evaluacion'];
    public $timestamps = false;

    protected $casts = [
        'fecha_evaluacion' => 'date',
    ];

    /**
     * Relación de una evaluación con un usuario (inquilino).
     */
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    /**
     * Relación de una evaluación con un apartamento.
     */
    public function apartamento()
    {
        return $this->belongsTo(Apartamento::class, 'apartamento_id');
    }
}
