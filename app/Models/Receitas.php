<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Receitas extends Model
{
    protected $fillable = [
        'user_id',
        'categoria_id',
        'titulo',
        'descricao',
        'modo_preparo',
        'tempo_preparo',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categoria()
    {
        return $this->belongsTo(Categorias::class);
    }

    public function ingredientes()
    {
        return $this->belongsToMany(Ingredientes::class)
                    ->withPivot('quantidade')
                    ->withTimestamps();
    }

    public function favoritos()
    {
        return $this->hasMany(Favoritos::class);
    }
}