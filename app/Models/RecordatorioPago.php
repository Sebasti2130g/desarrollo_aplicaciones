<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
