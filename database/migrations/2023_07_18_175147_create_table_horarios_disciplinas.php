<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Crie a tabela 'horarios'
        Schema::create('horarios', function (Blueprint $table) {
            $table->id();
            $table->string('dia_semana');
            $table->time('horario_inicio');
            $table->time('horario_fim');
            $table->timestamps();
        });

        // Insira os dados na tabela 'horarios' com intervalo de 50 minutos
        $diasSemana = ['segunda', 'terca', 'quarta', 'quinta', 'sexta', 'sabado'];

        foreach ($diasSemana as $dia) {
            $horarioInicio = strtotime('07:00');
            $horarioFim = strtotime('22:40');

            $horarios = [];
            while ($horarioInicio <= $horarioFim) {
                $horario = [
                    'dia_semana' => $dia,
                    'horario_inicio' => date('H:i:s', $horarioInicio),
                    'horario_fim' => date('H:i:s', $horarioInicio + 50 * 60),
                ];
                $horarios[] = $horario;
                $horarioInicio += 50 * 60;
            }

            DB::table('horarios')->insert($horarios);
        }
    }

    public function down()
    {
        // Se necessário, remova a tabela 'horarios'
        Schema::dropIfExists('horarios');
    }
};