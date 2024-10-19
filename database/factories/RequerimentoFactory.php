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
        $respostaPreenchida = $this->faker->randomElement([true, false]);

        $situacao = $respostaPreenchida ? $this->faker->randomElement(['Em andamento', 'Concluído', 'Recusado', 'Informações incompletas']) : $this->faker->randomElement(['Pendente', 'Em andamento', 'Concluído', 'Recusado', 'Informações incompletas']);

        $usuarios = User::pluck('id');

        if ($usuarios->isEmpty()) {
            $id_usuario = null;
        } else {
            $id_usuario = $usuarios->random();
        }

        return [
            'id_usuario' => $id_usuario,
            'titulo' => $this->faker->word,
            'tipo' => $this->faker->randomElement(['Denúncia', 'Sugestão']),
            'situacao' => $situacao,
            'data' => $this->faker->unique()->date,
            'descricao' => $this->faker->text,
            'cep' => $this->faker->numerify('##.###-###'),
            'cidade' => $this->faker->city,
            'bairro' => $this->faker->word,
            'logradouro' => $this->faker->streetName,

            'resposta' => $respostaPreenchida ? $this->faker->text : null,
            'id_administrador' => $respostaPreenchida ? User::where('type', 1)->pluck('id')->random() : null,
        ];
    }
}
