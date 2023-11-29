<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Libro extends Model
{
    use HasFactory, SoftDeletes; 

    protected $table = 'libros'; 
    protected $primaryKey = 'IdLibro';


    protected $dates = ['deleted_at'];

    protected $fillable = [
        'TituloLibro',
        'IdAutor',
        'IdCategoria',
        'IdEditorial',
        'CantidadLibro',
        'CantidadLibroIngresado',
        'DescripcionLibro',
    ];

    public function autor()
    {
        return $this->belongsTo(Autors::class, 'IdAutor');
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'IdCategoria');
    }

    public function editorial()
    {
        return $this->belongsTo(Editorials::class, 'IdEditorial');
    }

    public function prestamos()
    {
        return $this->hasMany(Prestamo::class, 'IdLibro');
    }
}
