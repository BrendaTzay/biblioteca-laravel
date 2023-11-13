<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    protected $table = 'categorias'; 
    protected $primaryKey = 'IdCategoria';

    protected $fillable = [
        'NombreCategoria',
    ];

    
    public function libros()
    {
        return $this->hasMany(Libro::class, 'IdCategoria');
    }
}
