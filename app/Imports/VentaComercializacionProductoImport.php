<?php

namespace sis5cs\Imports;

use sis5cs\VentaComercializacionProducto;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Session;
class VentaComercializacionProductoImport implements ToModel, WithHeadingRow, WithCalculatedFormulas
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {        

        return new VentaComercializacionProducto([
           
            'producto'     => $row['producto'], //a
            'cantidad'    => $row['cantidad'], //b
            'unidad_medida'    => $row['unidad_medida'],
            'c_costo_unitario'    => $row['c_costo_unitario'],
            'c_costo_total'    => $row['c_costo_total'],
            'v_precio_unitario'    => $row['v_precio_unitario'],
            'v_precio_total'    => $row['v_precio_total'],
            'utilidad'    => $row['utilidad'],
            'porcentaje'    => $row['porcentaje'],
            'id_persona'    => session('id_persona'),
            'id_credito'    => session('id_credito'),
            'detalle'    => $row['detalle'],
        ]);
    }
}
