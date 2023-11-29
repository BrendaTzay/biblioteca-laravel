<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

    public function up()
    {
        Schema::table('prestamos', function (Blueprint $table) {
            // Eliminar la clave foránea actual
            $table->dropForeign(['IdUsuario']);

            // Re-crear la clave foránea sin onDelete cascade
            $table->foreign('IdUsuario')->references('IdUsuario')->on('usuarios')->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::table('prestamos', function (Blueprint $table) {
            // Al revertir, vuelve a agregar la acción onDelete cascade
            $table->dropForeign(['IdUsuario']);
            $table->foreign('IdUsuario')->references('IdUsuario')->on('usuarios')->onUpdate('cascade')->onDelete('cascade');
        });
    }
};
