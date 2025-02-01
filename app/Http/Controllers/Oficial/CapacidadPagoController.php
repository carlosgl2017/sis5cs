<?php

namespace sis5cs\Http\Controllers\Oficial;

use sis5cs\Http\Controllers\Controller;
use Illuminate\Http\Request;
use sis5cs\Http\Requests\CapacidadPagoFormRequest;
use sis5cs\CapacidadPago;
use sis5cs\TipoCredito;
use Session;

class CapacidadPagoController extends Controller
{
    public $id_persona;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if (session('id_persona') == null||session('id_credito')==null) {
            alert()->info('Info', 'Seleccione un socio y credito')->showConfirmButton();
            return redirect('oficial/dashboard/');
        } else {
            $capacidad = CapacidadPago::where('id_persona', session('id_persona'))->where('id_credito', session('id_credito'))->get();
            return view('oficial.capacidad_pago.index')->with(compact('capacidad'));
        }

    }

    public function create()
    {
        if (session('id_persona') == null||session('id_credito')==null) {
            alert()->info('Info', 'Seleccione un socio y credito')->showConfirmButton();
            return redirect('oficial/dashboard/');
        } else {
            $if_exist = CapacidadPago::where('id_persona', session('id_persona'))->where('id_credito', session('id_credito'))->count();
            if ($if_exist > 0) {
                alert()->info('Info', 'Ya registro los datos de capacidad de pago.')->showConfirmButton();
                return redirect('oficial/capacidad_pago/');
            } else {
                $tipo_credito = TipoCredito::all();
                return view('oficial.capacidad_pago.create')->with(compact('tipo_credito'));
            }


        }

    }

    public function store(CapacidadPagoFormRequest $request)
    {
        $capacidad = new CapacidadPago();
        $capacidad->porcentaje = $request->input('porcentaje');
        $capacidad->amortizacion_coop_san_martin = $request->input('amortizacion_coop_san_martin');
        $capacidad->id_persona = $request->input('id_persona');
        $capacidad->id_credito = $request->input('id_credito');
        $capacidad->save(); //metodo se encarga de ejecutar un insert sobre la tabla
        flash()->addSuccess('Registro Exitoso', 'El registro ha sido guardado correctamente');
        return redirect('oficial/capacidad_pago');
    }

    public function edit($id)
    {
        if (session('id_persona') == null) {
            alert()->info('Info', 'Seleccione un socio')->showConfirmButton();
            return redirect('oficial/dashboard/');
        } else {
            $capacidad = CapacidadPago::find($id);
            return view('oficial.capacidad_pago.edit')->with(compact('capacidad')); //formulario de registro
        }

    }

    public function update(CapacidadPagoFormRequest $request, $id)
    {
        $capacidad = CapacidadPago::find($id);
        $capacidad->porcentaje = $request->input('porcentaje');
        $capacidad->amortizacion_coop_san_martin = $request->input('amortizacion_coop_san_martin');
        $capacidad->id_persona = $request->input('id_persona');
        $capacidad->id_credito = $request->input('id_credito');
        $capacidad->save(); //metodo se encarga de ejecutar un insert sobre la tabla
        flash()->addSuccess('Registro Exitoso', 'El registro ha sido guardado correctamente');
        return redirect('/oficial/capacidad_pago');
    }
}
