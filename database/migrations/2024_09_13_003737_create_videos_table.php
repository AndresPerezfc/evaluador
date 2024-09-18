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
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('proposito');
            $table->text('publico_objetivo');
            $table->text('plataformas');
            $table->string('url_video');
            $table->string('tipo_presentacion');
            $table->string('incrustable');
            $table->string('innovador');
            $table->string('identificacion');
            $table->string('email');
            $table->string('telefono');
            $table->string('rol_autor');
            $table->string('institucion_educativa')->nullable();
            $table->string('departamento')->nullable();
            $table->string('ciudad')->nullable();
            $table->string('coautor')->nullable();
            $table->double('puntaje')->nullable();
            $table->foreignId('category_id')->constrained('categories');
            $table->boolean('extra_puntos')->default(0);
            $table->text('comentario_general')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('videos');
    }
};
