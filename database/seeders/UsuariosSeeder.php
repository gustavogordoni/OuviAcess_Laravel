<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UsuariosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Criando usuário administrador
        User::create([
            'name' => 'Gustavo Luiz Gordoni',
            'type' => User::USER_TYPE_ADMIN,
            'ddd' => '(17)',
            'phone' => '99999-9999',
            'email' => 'a@a.com',
            'password' => bcrypt('123')
        ]);

        // Criando usuário comum
        User::create([
            'name' => 'Thiago Ferreira Caires',
            'type' => User::USER_TYPE_COMMON,
            'ddd' => '(17)',
            'phone' => '99999-9999',
            'email' => 'b@b.com',
            'password' => bcrypt('123')
        ]);

        // Criando usuário comum
        User::create([
            'name' => 'Julio Cesar Ortiz',
            'type' => User::USER_TYPE_ADMIN,
            'ddd' => '(17)',
            'phone' => '99999-9999',
            'email' => 'c@c.com',
            'password' => bcrypt('123')
        ]);

        // Criando usuário comum
        User::create([
            'name' => 'Anna Julia',
            'type' => User::USER_TYPE_COMMON,
            'ddd' => '(17)',
            'phone' => '99999-9999',
            'email' => 'd@d.com',
            'password' => bcrypt('123')
        ]);
        
        User::factory(5)->create();
    }
}
