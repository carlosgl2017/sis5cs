<?php

namespace sis5cs;

use Illuminate\Database\Eloquent\Model;

class ControlOficial extends Model
{
    protected $table='control_oficial';
    protected $primaryKey='id_control';
    public    $timestamps=true;

    protected $fillable=[
        'fecha_inicio',
        'fecha_fin',
        'id_visita'
        
    ];
}
