<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Editorials extends Model
{
    use HasFactory;

    protected $table = 'editorials'; 
    protected $primaryKey = 'IdEditorial';

    protected $fillable = [
        'NombreEditorial',
    ];

    
    public function libros()
    {
        return $this->hasMany(Libro::class, 'IdEditorial');
    }
}
