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
            'phone' => '(17) 97834-1298',
            'email' => 'gustavo@gmail.com',
            'password' => bcrypt('123456')
        ]);

        // Criando usuário comum
        User::create([
            'name' => 'Thiago Ferreira Caires',
            'type' => User::USER_TYPE_COMMON,
            'phone' => '(17) 98765-4321',
            'email' => 'thiago@gmail.com',
            'password' => bcrypt('123456')
        ]);

        // Criando usuário administrador
        User::create([
            'name' => 'Julio Cesar Ortiz',
            'type' => User::USER_TYPE_ADMIN,
            'phone' => '(17) 94567-8910',
            'email' => 'julio@gmail.com',
            'password' => bcrypt('123456')
        ]);

        // Criando usuário comum
        User::create([
            'name' => 'Anna Julia',
            'type' => User::USER_TYPE_COMMON,
            'phone' => '(17) 93210-5678',
            'email' => 'anna@gmail.com',
            'password' => bcrypt('123456')
        ]);


        User::factory(50)->create();
    }
}
