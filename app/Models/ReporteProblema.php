<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReporteProblema extends Model
{
    use HasFactory;

    protected $table = 'reporte_problema';
    protected $fillable = ['apartamento_id', 'usuario_id', 'descripcion', 'estado', 'fecha_reporte'];

    protected $casts = [
        'fecha_reporte' => 'datetime',
    ];
    public $timestamps = false;

    /**
     * Relación de un reporte de problema con un apartamento.
     */
    public function apartamento()
    {
        return $this->belongsTo(Apartamento::class, 'apartamento_id');
    }

    /**
     * Relación de un reporte de problema con un usuario.
     */
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }
}
