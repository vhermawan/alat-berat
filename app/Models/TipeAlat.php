<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TipeAlat
 * 
 * @property int $id
 * @property string|null $merk
 * @property string|null $nama
 * @property int|null $id_jenis_alat
 * @property string|null $kapasitas_bucket
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class TipeAlat extends Model
{
	protected $table = 'tipe_alat';

	protected $casts = [
		'id_jenis_alat' => 'int'
	];

	protected $fillable = [
		'merk',
		'nama',
		'id_jenis_alat',
		'kapasitas_bucket'
	];
}
