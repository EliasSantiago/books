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
        Schema::create('indices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_id');
            $table->foreignId('indice_pai_id')->nullable();
            $table->string('titulo');
            $table->integer('pagina');
            $table->timestamps();
            $table->foreign('book_id')->references('id')->on('books');
            $table->foreign('indice_pai_id')->references('id')->on('indices');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('indices');
    }
};
