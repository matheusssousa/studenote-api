<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notas extends Model
{
    use HasFactory;
    protected $fillable = ['nome', 'descricao', 'data_prazo', 'disciplina_id', 'user_id', 'annotation_community'];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id');
    }
    public function disciplina()
    {
        return $this->belongsTo(Disciplina::class);
    }
    public function categorias()
    {
        return $this->belongsToMany(Categoria::class, 'categoria_notas', 'nota_id', 'categoria_id')->withPivot('id');
    }
    public function files()
    {
        return $this->hasMany(FilesNotas::class, 'nota_id');
    }
    public function comentarios()
    {
        return $this->hasMany(Comentario::class, 'nota_id')->with('user');
    }
    public function likes()
    {
        return $this->belongsToMany(User::class, 'like_notas', 'nota_id', 'user_id')->withPivot('id');
    }
}
