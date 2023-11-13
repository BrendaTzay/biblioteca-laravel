<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Autors extends Model
{
    use HasFactory;

    protected $table = 'autors'; 
    protected $primaryKey = 'IdAutor';

    protected $fillable = [
        'NombreAutor',
        'ApellidoAutor',
    ];

    // Relaciones con otros modelos (si las tienes)
    public function libros()
    {
        return $this->hasMany(Libro::class, 'IdAutor');
    }
}
