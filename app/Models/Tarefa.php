<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarefa extends Model
{
    use HasFactory;
    protected $fillable = ['nome','descricao','data_fim', 'disciplina_id'];

    public function disciplina() {
        return $this->hasMany(Disciplina::class);
    }
    public function categorias() {
        return $this->belongsToMany(Categoria::class, 'categorias_tarefas', 'tarefa_id', 'categoria_id')->withPivot('id');
    }
}
