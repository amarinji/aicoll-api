<?php

namespace App\Infrastructure\Persistence\Eloquent;

use Illuminate\Database\Eloquent\Model;

class EmpresaModel extends Model
{
    protected $table = 'empresas';

    protected $fillable = ['nit', 'nombre', 'direccion', 'telefono', 'estado'];
}
