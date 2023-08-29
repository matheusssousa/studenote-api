<?php

namespace App\Models;

use App\Http\Controllers\NotasController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FilesNotas extends Model
{
    use HasFactory;
    protected $fillable = ['arquivo', 'nome_arquivo', 'arquivo_type', 'nota_id'];

    public function nota()
    {
        return $this->belongsTo(NotasController::class);
    }
}
