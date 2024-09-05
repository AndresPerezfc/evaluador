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
        Schema::create('innovations', function (Blueprint $table) {
            $table->id();
            $table->string('rol_autor');
            $table->string('categoria_autor')->nullable();;
            $table->string('titulo');
            $table->text('descripcion');
            $table->text('proceso');
            $table->string('url');
            $table->string('presentacion');
            $table->string('innovador');
            $table->string('identificación');
            $table->string('email');
            $table->string('perfil_instagram')->nullable();;
            $table->string('telefono');
            $table->string('vinculacion')->nullable();;
            $table->string('dependencia')->nullable();;
            $table->string('dependencia_aliada')->nullable();;
            $table->string('facultad')->nullable();;
            $table->string('programa')->nullable();;
            $table->string('colegio')->nullable();;
            $table->string('coautor')->nullable();;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('innovations');
    }
};
