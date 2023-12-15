<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Requerimento>
 */
class RequerimentoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'id_usuario' => User::pluck('id')->random(),
            'titulo' => $this->faker->word,
            'tipo' => $this->faker->randomElement(['Denúncia', 'Sugestão']),
            'situacao' => $this->faker->randomElement(['Pendente', 'Em andamento', 'Concluído', 'Recusado', 'Informações incompletas']),
            'data' => $this->faker->unique()->date,
            'descricao' => $this->faker->text,
            'cep' => $this->faker->numerify('##.###-###'),
            'cidade' => $this->faker->city,
            'bairro' => $this->faker->word,
            'logradouro' => $this->faker->streetName,
            'resposta' => $this->faker->text,
        ];
    }
}
