<?php

namespace BolsaTrabajo;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Datos extends Model
{
    protected $table = 'empresa'; // Nombre de la tabla
    use SoftDeletes;

    protected $fillable = [
        'nombre','ruc','direccion','email','web','tel','logo'
    ];

    public $timestamps = false;

    protected $dates = ['deleted_at'];

   /*  public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'dni', 'dni'); // Ajusta los parámetros según tu esquema
    } */
}
