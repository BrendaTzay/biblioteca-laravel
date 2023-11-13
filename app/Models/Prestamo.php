<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prestamo extends Model
{
    use HasFactory;

    protected $table = 'prestamos';
    protected $primaryKey = 'IdPrestamo';

    protected $fillable = [
        'IdUsuario',
        'IdLibro',
        'FechaSalida',
        'FechaDevolucion',
        'EstadoPrestamo',
        'ObservacionPrestamo',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'IdUsuario');
    }

    public function libro()
    {
        return $this->belongsTo(Libro::class, 'IdLibro')->withTrashed();
    }
}
