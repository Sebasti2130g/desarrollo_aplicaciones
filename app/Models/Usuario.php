<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Usuario",
 *     title="Usuario",
 *     type="object",
 *     required={"nombre", "correo", "telefono", "contraseña"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="nombre", type="string", example="Juan Pérez"),
 *     @OA\Property(property="correo", type="string", format="email", example="juan@example.com"),
 *     @OA\Property(property="telefono", type="string", example="123456789"),
 *     @OA\Property(property="contraseña", type="string", example="********")
 * )
 */
class Usuario extends Model
{
    use HasFactory;

    protected $table = 'usuario'; // Tabla en la base de datos
    protected $fillable = ['nombre', 'correo', 'telefono', 'contraseña']; // Campos que se pueden asignar masivamente
    public $timestamps = false;

    /**
     * Relación de un usuario con muchos contratos.
     */
    public function contratos()
    {
        return $this->hasMany(Contrato::class, 'usuario_id');
    }

    /**
     * Relación de un usuario con muchas quejas.
     */
    public function quejas()
    {
        return $this->hasMany(Queja::class, 'usuario_id');
    }

    /**
     * Relación de un usuario con muchos reportes de problemas.
     */
    public function reportesProblema()
    {
        return $this->hasMany(ReporteProblema::class, 'usuario_id');
    }

    /**
     * Relación de un usuario con muchas evaluaciones.
     */
    public function evaluaciones()
    {
        return $this->hasMany(Evaluacion::class, 'usuario_id');
    }

    /**
     * Relación de un usuario con muchas solicitudes de alquiler.
     */
    public function solicitudesAlquiler()
    {
        return $this->hasMany(SolicitudAlquiler::class, 'usuario_id');
    }

    /**
     * Relación de un usuario con muchos estados de alquiler.
     */
    public function estadosAlquiler()
    {
        return $this->hasMany(EstadoAlquiler::class, 'usuario_id');
    }

    /**
     * Relación de un usuario con muchos recordatorios de pago.
     */
    public function recordatoriosPago()
    {
        return $this->hasMany(RecordatorioPago::class, 'usuario_id');
    }

    /**
     * Relación con los roles (muchos a muchos).
     */
    public function roles()
    {
        return $this->belongsToMany(Rol::class, 'usuario_roles', 'usuario_id', 'rol_id');
    }
}
