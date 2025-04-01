<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Queja extends Model
{
    use HasFactory;

    protected $table = 'queja';
    protected $fillable = ['usuario_id', 'descripcion', 'tipo', 'fecha_envio'];

    protected $casts = [
        'fecha_envio' => 'datetime',
    ];
    public $timestamps = false;
    /**
     * Relación de una queja con un usuario.
     */
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }
}
