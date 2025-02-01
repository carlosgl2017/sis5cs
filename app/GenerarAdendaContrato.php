<?php

namespace sis5cs;

use Illuminate\Database\Eloquent\Model;

class GenerarAdendaContrato extends Model
{
    protected $table='prestamos_info';
    protected $primaryKey='nroprestamo';
    public $timestamps=true;

    protected $fillable=[
        'nroprestamo',
        'dnombre',
        'dci',
        'destadocivil',
        'ddireccion',
        'cnombre',
        'cci',
        'cestadocivil',
        'cdireccion',
        'fechacontrato',
        'nnotaria',
        'nombreaboga',
        'montoprestamo',
        'mesesampliacion',
        'cuotasadicionales',
        'namortizaciones',
        'montodiferido',
        'mesiniciopago',
        'nrocodeudores',
        'amortiza2'
    ];
}
