<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Edificio extends Model
{
    use HasFactory;

    protected $table = 'edificio';
    protected $fillable = ['nombre', 'direccion', 'cantidad_pisos'];
    public $timestamps = false;
    /**
     * Relación de un edificio con muchos apartamentos.
     */
    public function apartamentos()
    {
        return $this->hasMany(Apartamento::class, 'edificio_id');
    }
}
