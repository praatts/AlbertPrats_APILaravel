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
        Schema::create('animals', function (Blueprint $table) {
            $table->id('id_animal');
            $table->string('nombre')->nullable(false);
            $table->enum('tipo', ['perro', 'gato', 'conejo', 'hámster'])->nullable(false);
            $table->double('peso');
            $table->string('enfermedad');
            $table->text('comentarios');
            $table->foreignId('owner_id')->constrained('owners', 'id_persona')->cascadeOnDelete();
            $table->string('test');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('animals');
    }
};
