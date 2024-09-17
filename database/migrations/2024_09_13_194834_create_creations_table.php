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
        Schema::create('creations', function (Blueprint $table) {
            $table->id();
            $table->string('rol_autor');
            $table->string('categoria_autor')->nullable();;
            $table->string('titulo');
            $table->text('tematica');
            $table->text('problematica');
            $table->string('presentacion');
            $table->string('tipo_presentacion');
            $table->string('incrustable');
            $table->string('cocreador');
            $table->string('identificación');
            $table->string('email');
            $table->string('perfil_instagram')->nullable();;
            $table->string('telefono');
            $table->string('vinculacion')->nullable();
            $table->string('dependencia')->nullable();
            $table->string('facultad')->nullable();
            $table->string('programa')->nullable();
            $table->string('colegio')->nullable();
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
        Schema::dropIfExists('creations');
    }
};
