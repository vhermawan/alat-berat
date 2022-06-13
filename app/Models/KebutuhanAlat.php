<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class KebutuhanAlat
 * 
 * @property int $id
 * @property int|null $id_tipe_alat
 * @property int|null $id_volume_pekerjaan
 * @property float|null $hasil
 * @property string|null $parameter
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class KebutuhanAlat extends Model
{
	protected $table = 'kebutuhan_alat';

	protected $casts = [
		'id_tipe_alat' => 'int',
		'id_volume_pekerjaan' => 'int',
		'hasil' => 'float'
	];

	protected $fillable = [
		'id_tipe_alat',
		'id_volume_pekerjaan',
		'hasil',
		'parameter'
	];
}
