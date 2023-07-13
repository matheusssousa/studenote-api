<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriasTarefa extends Model
{
    use HasFactory;
    protected $fillable = ['categoria_id','tarefa_id'];
}
