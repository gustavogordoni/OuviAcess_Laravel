<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Arquivo extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id_requerimento',
        'name',
    ];

    public function requerimento(){
        return $this->belongsTo(Requerimento::class, 'id_requerimento');
    }
}
