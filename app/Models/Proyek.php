<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Proyek
 * 
 * @property int $id
 * @property string|null $nama
 * @property string|null $lokasi
 * @property string|null $sumber_dana
 * @property float|null $budget
 * @property string|null $retensi
 * @property string|null $jenis_kontrak
 * @property string|null $jaminan_pelaksana
 * @property string|null $konsultan_perencana
 * @property string|null $konsultan_supervisi
 * @property string|null $pemilik_proyek
 * @property string|null $masa_pelaksanaan
 * @property string|null $masa_pemeliharaan
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Proyek extends Model
{
	protected $table = 'proyek';

	protected $casts = [
		'budget' => 'float'
	];

	protected $fillable = [
		'nama',
		'lokasi',
		'sumber_dana',
		'budget',
		'retensi',
		'jenis_kontrak',
		'jaminan_pelaksana',
		'konsultan_perencana',
		'konsultan_supervisi',
		'pemilik_proyek',
		'masa_pelaksanaan',
		'masa_pemeliharaan'
	];
}
