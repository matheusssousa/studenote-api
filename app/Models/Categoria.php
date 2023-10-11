<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;
    protected $fillable = ['nome', 'cor', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function notas()
    {
        return $this->belongsToMany(Notas::class, 'categoria_notas', 'categoria_id', 'nota_id')->withPivot('id');
    }
}
