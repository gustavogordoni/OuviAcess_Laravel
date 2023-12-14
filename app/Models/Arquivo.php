<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Arquivo extends Model
{
    use HasFactory;

    public function requerimento(){
        return $this->belongsTo(Requerimento::class, 'id_requerimento');
    }
}
