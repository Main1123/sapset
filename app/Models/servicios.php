<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class servicios extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'titulo',
        'precio',
        'imagen',
        'estado',
        'descripcion'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'precio' => 'decimal:2',
        'estado' => 'boolean'
    ];

    /**
     * Get the formatted precio with currency symbol.
     *
     * @return string
     */
    public function getPrecioFormatadoAttribute()
    {
        return '$' . number_format($this->attributes['precio'], 2);
    }

    /**
     * Get the estado as a string.
     *
     * @return string
     */
    public function getEstadoStringAttribute()
    {
        return $this->estado ? 'Activo' : 'Inactivo';
    }
}
