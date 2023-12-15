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
        User::create([
            'name' => 'Gustavo Luiz Gordoni',
            'ddd' => '(17)',
            'phone' => '99999-9999',
            'email' => 'a@a.com',
            'password' => bcrypt('123')
        ]);
        
        User::factory(5)->create();
    }
}
