<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Receitas extends Model
{
    protected $fillable = [
        'nome',
        'descricao',
        'users_id',
        'favoritos_id',
        'categoria_id'
    ];
}