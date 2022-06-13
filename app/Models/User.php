<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Class User
 * 
 * @property int $id
 * @property string|null $email
 * @property string|null $password
 *
 * @package App\Models
 */
class User extends Authenticatable
{

	use Notifiable;

	protected $table = 'users';
	public $timestamps = false;

	protected $hidden = [
		'password'
	];

	protected $fillable = [
		'email',
		'password'
	];
}
