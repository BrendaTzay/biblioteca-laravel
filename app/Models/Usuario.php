<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;

    protected $table = 'usuarios';
    protected $primaryKey = 'IdUsuario';

    protected $fillable = [
        'NombreUsuario',
        'ApellidoUsuario',
        'GradoUsuario',
        'CodigoUsuario',
        'DireccionUsuario',
        'TelefonoUsuario',
        'NacimientoUsuario',
    ];

    public function prestamos()
    {
        return $this->hasMany(Prestamo::class, 'IdUsuario');
    }
}
