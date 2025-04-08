<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Apartamento",
 *     title="Apartamento",
 *     required={"usuario_id", "edificio_id", "numero_apartamento", "piso", "precio", "tamaño"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="usuario_id", type="integer", example=2),
 *     @OA\Property(property="edificio_id", type="integer", example=1),
 *     @OA\Property(property="numero_apartamento", type="string", example="A101"),
 *     @OA\Property(property="piso", type="integer", example=2),
 *     @OA\Property(property="precio", type="number", format="float", example=950000),
 *     @OA\Property(property="tamaño", type="number", format="float", example=75.5)
 * )
 */

class Apartamento extends Model
{
    use HasFactory;

    protected $table = 'apartamento';
    protected $fillable = ['usuario_id', 'edificio_id', 'numero_apartamento', 'piso', 'precio', 'tamaño'];
    public $timestamps = false;
    /**
     * Relación de un apartamento con un usuario (propietario).
     */
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    /**
     * Relación de un apartamento con un edificio.
     */
    public function edificio()
    {
        return $this->belongsTo(Edificio::class, 'edificio_id');
    }

    /**
     * Relación de un apartamento con muchos contratos.
     */
    public function contratos()
    {
        return $this->hasMany(Contrato::class, 'apartamento_id');
    }

    /**
     * Relación de un apartamento con muchos reportes de problemas.
     */
    public function reportesProblema()
    {
        return $this->hasMany(ReporteProblema::class, 'apartamento_id');
    }

    /**
     * Relación de un apartamento con muchas evaluaciones.
     */
    public function evaluaciones()
    {
        return $this->hasMany(Evaluacion::class, 'apartamento_id');
    }
}
