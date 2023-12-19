<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requerimento extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_usuario',
        'titulo',
        'tipo',
        'situacao',
        'data',
        'descricao',
        'cep',
        'cidade',
        'bairro',
        'logradouro',
        'resposta',
        'id_administrador',
    ];

    public function usuario(){
        return $this->belongsTo(User::class, 'id_usuario');
    }
}
