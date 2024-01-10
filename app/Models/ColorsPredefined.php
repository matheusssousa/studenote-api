<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ColorsPredefined extends Model
{
    use HasFactory;
    protected $fillable = ['cor_1', 'cor_2', 'cor_3',];

    public function notas()
    {
        return $this->hasMany(Notas::class);
    }
}
