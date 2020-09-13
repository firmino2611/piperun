<?php

namespace Database\Seeders;

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
        User::query()->create(array(
            'name' => 'Admin Pipe Run',
            'email' => 'admin@piperun.com.br',
            'password' => bcrypt('admin'),
        ));
    }
}
