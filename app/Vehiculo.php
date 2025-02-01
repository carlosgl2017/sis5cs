<?php

namespace sis5cs;

use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
    protected $table = 'vehiculo';
    protected $primaryKey = 'id_vehiculo';
    public $timestamps = true;

    protected $fillable = [
        'tipo',
        'marca',
        'modelo',
        'placa',
        'rua',
        'en_garantia',
        'valor',
        'id_persona',
        'id_credito',
        'marcabaja'
    ];

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'id_persona');
    }

}
