<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Configuracion extends Model
{
    protected $fillable = [
        'nombre',
        'valor',
        'descripcion',
    ];

    protected $table = 'configuraciones';
}
