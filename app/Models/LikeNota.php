<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LikeNota extends Model
{
    use HasFactory;
    protected $fillable = ['nota_id', 'user_id'];
}
