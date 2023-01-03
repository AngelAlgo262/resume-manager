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
        User::create([
            'name' => 'Angel Ocampo',
            'email' => 'angelocampo262@gmail.com',
            'password' => bcrypt('Desarrollo.123')
        ]);

        User::create([
            'name' => 'Invitado',
            'email' => 'invitado@invitado.com',
            'password' => bcrypt('Invitado*123')
        ]);
    }
}
