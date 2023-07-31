<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disciplina extends Model
{
    use HasFactory;
    protected $fillable = ['nome', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function notas()
    {
        return $this->hasMany(Notas::class);
    }
}
