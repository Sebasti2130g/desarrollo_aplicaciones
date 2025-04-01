<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoAlquiler extends Model
{
    use HasFactory;

    protected $table = 'estado_alquiler';
    protected $fillable = ['contrato_id', 'usuario_id', 'estado', 'fecha_reporte'];

    protected $casts = [
        'fecha_reporte' => 'datetime',
    ];
    public $timestamps = false;
    /**
     * Relación de un estado de alquiler con un contrato.
     */
    public function contrato()
    {
        return $this->belongsTo(Contrato::class, 'contrato_id');
    }

    /**
     * Relación de un estado de alquiler con un usuario (administrador).
     */
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }
}
