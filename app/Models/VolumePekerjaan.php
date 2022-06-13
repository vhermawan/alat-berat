<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class VolumePekerjaan
 * 
 * @property int $id
 * @property string|null $nama
 * @property float|null $nilai
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class VolumePekerjaan extends Model
{
	protected $table = 'volume_pekerjaan';

	protected $casts = [
		'nilai' => 'float'
	];

	protected $fillable = [
		'nama',
		'nilai'
	];
}
