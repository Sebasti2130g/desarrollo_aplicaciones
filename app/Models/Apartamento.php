<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
