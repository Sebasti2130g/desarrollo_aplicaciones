<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolicitudAlquiler extends Model
{
    use HasFactory;

    protected $table = 'solicitud_alquiler';
    protected $fillable = ['fecha_solicitud', 'usuario_id', 'apartamento_id', 'estado_solicitud'];
    public $timestamps = false;

    /**
     * Relación de una solicitud de alquiler con un usuario.
     */
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    /**
     * Relación de una solicitud de alquiler con un apartamento.
     */
    public function apartamento()
    {
        return $this->belongsTo(Apartamento::class, 'apartamento_id');
    }
}
