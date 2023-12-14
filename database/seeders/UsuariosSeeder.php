<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Usuario;

class UsuariosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Usuario::create([
            'nome' => 'Gustavo Luiz Gordoni',
            'ddd' => '(17)',
            'telefone' => '99999-9999',
            'email' => 'a@a.com',
            'senha' => bcrypt('123')
        ]);
        
        Usuario::factory(5)->create();
    }
}
