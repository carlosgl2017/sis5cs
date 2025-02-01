<?php

namespace sis5cs;

use Illuminate\Database\Eloquent\Model;

class ControlDistanciaOficial extends Model
{
    protected $table='control_distancia_oficial';
    protected $primaryKey='id_control_distancia';
    public    $timestamps=true;

    protected $fillable=[
        'latitud',
        'longitud',
        'id_control'
        
    ];
}
