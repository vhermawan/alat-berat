<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;


class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'email' => 'admin@admin.com',
                'password' => bcrypt('12345678'),
            ]
        ];
        User::insert($data);
    }
}
