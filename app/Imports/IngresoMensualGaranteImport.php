<?php

namespace sis5cs\Imports;

use sis5cs\IngresoMensual;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Session;

class IngresoMensualGaranteImport implements ToModel,WithHeadingRow, WithCalculatedFormulas
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new IngresoMensual([
            'mes'     => $row['mes'], //a
            'anio'    => $row['anio'], //b
            'prestatario'    => $row['prestatario'],
            'conyugue'    => $row['conyugue'],
            'otros'    => $row['otros'],
            'codeudores'    => $row['codeudores'],
            'total_ingreso'    => $row['total_ingreso'],
            'descripcion'    => $row['descripcion'],
            'id_persona'    => session('id_persona_garante'),
            'id_credito'    => session('id_credito'),
        ]);
    }
}
