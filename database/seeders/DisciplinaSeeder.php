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
        $disciplinas = [
            'AEDS I',
            'Administração',
            'AEDS II',
            'Inglês I',
            'Inglês II',
            'Português',
            'Comp. Sociedade',
            'Fundamentos SI',
            'Intro. Computação',
            'Matemática Comp.',
            'Arquitetura',
            'Cálculo',
            'GAAL',
            'Metodologia Cientifica',
            'Probabilidade Estatistica',
            'TGS',
            'Banco de Dados I',
            'Banco de Dados II',
            'Engenharia de Soft. I',
            'Engenharia de Soft. II',
            'Cálculo Numérico',
            'Gestão da Info.',
            'Grafos',
            'Programação I',
            'Programação II',
            'SIG',
            'Teoria da Computação',
            'Gestão Financeira',
            'IHC',
            'Marketing',
            'Redes',
            'Sistemas Operacionais',
            'Qualidade de Soft.',
            'Pesquisa Operacional',
            'Computação Gráfica',
            'Desenvolvimento Web',
            'Comunicação de Dados',
            'Sistemas Distrib. I',
            'Inteligência Artificial',
            'Gerência Proj. Soft.',
            'Psicologia Organizacional',
            'PTCC',
            'Optativa I',
            'Optativa II',
            'Optativa III',
            'Optativa IV',
            'Sistemas Distrib. II',
            'Gestão Processos',
            'Empreend. Informática',
            'Economia Finanças',
            'TCC I',
            'TCC II',
            'SAD',
            'Segurança Auditoria',
            'Lesgislação e Ética',
            'Sociologia',
            'Filosofia e Ética',            
        ];

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
