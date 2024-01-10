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
        Schema::create('colors_predefineds', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('cor_1');
            $table->string('cor_2');
            $table->string('cor_3');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('colors_predefineds');
    }
};
