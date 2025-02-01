<?php

namespace sis5cs;

use Illuminate\Database\Eloquent\Model;

class Visita extends Model
{
    protected $table='visita';
    protected $primaryKey='id_visita';
    public    $timestamps=true;

    protected $fillable=[
        'fecha_visita',
        'hora_visita',
        'duracion_minutos',
        'fecha_programacion',
        'latitud',
        'longitud',
        'direccion',
        'departamento',
        'ciudad',
        'provincia',
        'localidad',
        'aprobado',
        'estado',
        'borrado',
        'id_credito',
        'id_users'
    ];
}
