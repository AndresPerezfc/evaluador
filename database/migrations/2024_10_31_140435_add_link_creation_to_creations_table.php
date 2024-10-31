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
        Schema::table('creations', function (Blueprint $table) {
            $table->string('link_creation')->nullable()->after('comentario_general'); // Ajusta 'existing_column_name' a la columna anterior
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('creations', function (Blueprint $table) {
            //
        });
    }
};
