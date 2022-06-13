<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class JenisAlat
 * 
 * @property int $id
 * @property string|null $nama
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class JenisAlat extends Model
{
	protected $table = 'jenis_alat';

	protected $fillable = [
		'nama'
	];
}
