<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    use HasFactory;
    protected $fillable = ['comentario', 'comentario_pai', 'user_id', 'nota_id'];

    public function nota()
    {
        return $this->belongsTo(Notas::class);
    }
    public function user()
    {
        return $this->hasMany(User::class);
    }
    public function comentario()
    {
        return $this->hasMany(Comentario::class);   
    }
}
