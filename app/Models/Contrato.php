<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contrato extends Model
{
    use HasFactory;

    protected $table = 'contrato';
    protected $fillable = ['usuario_id', 'apartamento_id', 'fecha_inicio', 'fecha_fin', 'firma_digital'];

    protected $casts = [
        'fecha_inicio' => 'datetime',
        'fecha_fin' => 'datetime',
    ];
    public $timestamps = false;
    /**
     * Relación de un contrato con un usuario (inquilino).
     */
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    /**
     * Relación de un contrato con un apartamento.
     */
    public function apartamento()
    {
        return $this->belongsTo(Apartamento::class, 'apartamento_id');
    }

    /**
     * Relación de un contrato con muchos estados de alquiler.
     */
    public function estadosAlquiler()
    {
        return $this->hasMany(EstadoAlquiler::class, 'contrato_id');
    }
}
