<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;
    protected $fillable = ['nome','cor'];

    public function tarefas() {
        return $this->belongsToMany(Tarefa::class, 'categorias_tarefas', 'categoria_id', 'tarefa_id')->withPivot('id');
    }
}
