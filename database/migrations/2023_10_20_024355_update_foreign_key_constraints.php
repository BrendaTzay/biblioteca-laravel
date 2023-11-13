<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateForeignKeyConstraints extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('libros', function (Blueprint $table) {
            $table->dropForeign(['IdAutor']);
            $table->dropForeign(['IdCategoria']);
            $table->dropForeign(['IdEditorial']);
            
            $table->foreign('IdAutor')->references('IdAutor')->on('autors')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('IdCategoria')->references('IdCategoria')->on('categorias')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('IdEditorial')->references('IdEditorial')->on('editorials')->onUpdate('cascade')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('libros', function (Blueprint $table) {
            $table->dropForeign(['IdAutor']);
            $table->dropForeign(['IdCategoria']);
            $table->dropForeign(['IdEditorial']);
            
            $table->foreign('IdAutor')->references('IdAutor')->on('autors')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('IdCategoria')->references('IdCategoria')->on('categorias')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('IdEditorial')->references('IdEditorial')->on('editorials')->onUpdate('cascade')->onDelete('cascade');
        });
    }
}
