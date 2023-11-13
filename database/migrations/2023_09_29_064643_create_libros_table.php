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
        Schema::create('libros', function (Blueprint $table) {
           
            $table->bigIncrements('IdLibro');

            $table->string('TituloLibro');
            $table->unsignedBigInteger('IdAutor');
            $table->foreign('IdAutor')->references('IdAutor')->on('autors')->onUpdate('cascade')->onDelete('cascade');
        
            
            $table->unsignedBigInteger('IdCategoria');
            $table->foreign('IdCategoria')->references('IdCategoria')->on('categorias')->onUpdate('cascade')->onDelete('cascade');
        
            $table->unsignedBigInteger('IdEditorial');
            $table->foreign('IdEditorial')->references('IdEditorial')->on('editorials')->onUpdate('cascade')->onDelete('cascade');
            
            $table->integer('CantidadLibro');
            $table->text('DescripcionLibro');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('libros');
    }
};
