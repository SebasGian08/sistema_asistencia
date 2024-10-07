<?php

namespace BolsaTrabajo;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Empleado extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'id','dni','nombre','apellido','cargo_id','tel','email'
    ];

    public $timestamps = false;

    protected $dates = ['deleted_at'];

    public function cargo()
    {
        return $this->belongsTo(Cargo::class);
    }
}
