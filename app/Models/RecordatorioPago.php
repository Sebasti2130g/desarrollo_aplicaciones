<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *   schema="RecordatorioPago",
 *   type="object",
 *   title="Recordatorio de Pago",
 *   required={"usuario_id", "medio", "fecha_envio"},
 *   @OA\Property(property="id", type="integer", example=1),
 *   @OA\Property(property="usuario_id", type="integer", example=2),
 *   @OA\Property(property="medio", type="string", example="Correo electrónico"),
 *   @OA\Property(property="fecha_envio", type="string", format="date", example="2025-04-10")
 * )
 */
class RecordatorioPago extends Model
{
    use HasFactory;

    protected $table = 'recordatorio_pago';
    protected $fillable = ['usuario_id', 'medio', 'fecha_envio'];
    public $timestamps = false;
    /**
     * Relación de un recordatorio de pago con un usuario.
     */
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }
}
