<?php

namespace BolsaTrabajo;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tipo extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nombre'
    ];

    public $timestamps = false;

    protected $dates = ['deleted_at'];
}
