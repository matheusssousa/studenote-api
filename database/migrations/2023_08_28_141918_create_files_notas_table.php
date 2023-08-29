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
        Schema::create('files_notas', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('arquivo');
            $table->string('nome_arquivo');
            $table->unsignedBigInteger('nota_id');

            $table->foreign('nota_id')->references('id')->on('notas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('files_notas');
        Schema::enableForeignKeyConstraints();
    }
};
