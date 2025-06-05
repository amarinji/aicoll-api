<?php

namespace App\Infrastructure\Persistence\Eloquent;

use Illuminate\Database\Eloquent\Model;

class EmpresaModel extends Model
{
    protected $table = 'empresas';
    protected $primaryKey = 'nit';
    public $incrementing = false;

    // 3) Especifico el tipo de clave (string, porque nit viene como cadena numérica)
    protected $keyType = 'string';
    protected $fillable = ['nit', 'nombre', 'direccion', 'telefono', 'estado'];
}
