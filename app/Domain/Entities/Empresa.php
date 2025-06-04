<?php

namespace App\Domain\Entities;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    // app/Models/Empresa.php
    protected $primaryKey = 'nit';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['nit', 'nombre', 'direccion', 'telefono', 'estado'];

}
