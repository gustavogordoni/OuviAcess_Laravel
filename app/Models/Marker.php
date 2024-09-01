<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Marker extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'lat',
        'lng',
        'title',
        'description',
        // outros atributos, se necessário
    ];
}
