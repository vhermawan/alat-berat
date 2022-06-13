<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BiayaSewa
 * 
 * @property int $id
 * @property int|null $id_tipe_alat
 * @property float|null $hasil
 * @property string|null $parameter
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class BiayaSewa extends Model
{
	protected $table = 'biaya_sewa';

	protected $casts = [
		'id_tipe_alat' => 'int',
		'hasil' => 'float'
	];

	protected $fillable = [
		'id_tipe_alat',
		'hasil',
	];
}
