<?php

namespace Database\Seeders;

use App\Models\Disciplina;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DisciplinaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Disciplina::create([
            'nome' => 'AEDS I'
        ]);
        Disciplina::create([
            'nome' => 'Administração'
        ]);
        Disciplina::create([
            'nome' => 'Inglês I'
        ]);
    }
}
