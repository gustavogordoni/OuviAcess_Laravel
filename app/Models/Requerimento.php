<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requerimento extends Model
{
    use HasFactory;

    public function usuario(){
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }
}
