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
        Schema::create('usuarios', function (Blueprint $table) {
            
            $table->bigIncrements('IdUsuario');
            $table->string('NombreUsuario');
            $table->string('ApellidoUsuario');
            $table->string('GradoUsuario')->nullable();
            $table->string('CodigoUsuario')->unique();
            $table->string('DireccionUsuario');
            $table->string('TelefonoUsuario', 20)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
