<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
     /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('notas', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('nome', 50);
            $table->string('descricao', 2000);
            $table->date('data_prazo')->nullable();
            $table->unsignedBigInteger('disciplina_id');
            $table->unsignedBigInteger('user_id');  
            $table->boolean('annotation_community');
            $table->integer('likes');

            // CHAVE ESTRANGEIRA DE USUÁRIO
            $table->foreign('user_id')->references('id')->on('users');
            //CHAVE ESTRANGEIRA DE DISCIPLINA
            $table->foreign('disciplina_id')->references('id')->on('disciplinas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('notas');
        Schema::enableForeignKeyConstraints();
    }
};
