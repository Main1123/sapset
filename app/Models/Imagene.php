<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Imagene
 * 
 * @property int $id
 * @property string $path
 * @property string $filename
 * @property string $section
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Servicio[] $servicios
 *
 * @package App\Models
 */
class Imagene extends Model
{
	protected $table = 'imagenes';

	protected $fillable = [
		'path',
		'filename',
		'section'
	];

	public function servicios()
	{
		return $this->hasMany(Servicio::class, 'imagen_id');
	}
}
