<?php

namespace Database\Seeders;

use App\Models\Detail;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory(50)->has(Detail::factory())->create();
    }
}
