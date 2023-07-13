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
        Schema::create('categorias_tarefas', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('categoria_id');
            $table->unsignedBigInteger('tarefa_id');

            //CHAVES ESTRANGEIRAS
            $table->foreign('categoria_id')->references('id')->on('categorias');
            $table->foreign('tarefa_id')->references('id')->on('tarefas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('categorias_tarefas');
        Schema::enableForeignKeyConstraints();
    }
};
