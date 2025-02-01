<?php

namespace sis5cs;

use Illuminate\Database\Eloquent\Model;

class VentaComercializacionProducto extends Model
{
    protected $table = 'venta_comercializacion_productos';
    protected $primaryKey = 'id_venta_comercializacion';
    public $timestamps = true;
    protected $fillable = [
        'producto',
        'cantidad',
        'unidad_medida',
        'c_costo_unitario',
        'c_costo_total',
        'v_precio_unitario',
        'v_precio_total',
        'utilidad',
        'porcentaje',
        'id_persona',
        'detalle',
        'marcabaja',
        'id_credito',
        'id_persona',

    ];
}
