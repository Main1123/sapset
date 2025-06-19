<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Pedido
 * 
 * @property int $id
 * @property string $nombre_cliente
 * @property string $cedula
 * @property string $email
 * @property string $telefono
 * @property string $direccion
 * @property string|null $servicio_id
 * @property float $monto
 * @property string $estado
 * @property string|null $observaciones
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Pedido extends Model
{
	protected $table = 'pedidos';

	protected $casts = [
		'monto' => 'float'
	];

	protected $fillable = [
		'nombre_cliente',
		'cedula',
		'email',
		'telefono',
		'direccion',
		'servicio_id',
		'monto',
		'estado',
		'observaciones'
	];
}
