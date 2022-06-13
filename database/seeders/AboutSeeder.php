<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\About;


class AboutSeeder extends Seeder
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
                'content' => 'lorem ipsum',
            ]
        ];
        About::insert($data);
    }
}
