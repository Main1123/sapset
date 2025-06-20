<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Servicio
 * 
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string $titulo
 * @property string $descripcion
 * @property int $imagen_id
 * @property bool $active
 * 
 * @property Imagene $imagene
 *
 * @package App\Models
 */
class Servicio extends Model
{
	protected $table = 'servicios';

	protected $casts = [
		'imagen_id' => 'int',
		'active' => 'bool'
	];

	protected $fillable = [
		'titulo',
		'descripcion',
		'imagen_id',
		'active',
		'precio'
	];

	public function imagene()
	{
		return $this->belongsTo(Imagene::class, 'imagen_id');
	}
}
