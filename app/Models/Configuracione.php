<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Configuracione
 * 
 * @property int $id
 * @property string $nombre
 * @property string $valor
 * @property string|null $descripcion
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Configuracione extends Model
{
	protected $table = 'configuraciones';

	protected $fillable = [
		'nombre',
		'valor',
		'descripcion'
	];
}
