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
        Schema::create('comentarios', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('comentario', 2500);
            $table->unsignedBigInteger('comentario_pai')->nullable();
            $table->unsignedBigInteger('nota_id');
            $table->unsignedBigInteger('user_id');

            $table->foreign('nota_id')->references('id')->on('notas');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('comentarios');
        Schema::enableForeignKeyConstraints();
    }
};
