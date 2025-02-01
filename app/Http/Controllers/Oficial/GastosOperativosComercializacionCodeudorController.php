<?php

namespace sis5cs\Http\Controllers\Oficial;

use sis5cs\Http\Controllers\Controller;
use Illuminate\Http\Request;
use sis5cs\GastosOperativosComercializacion;
use sis5cs\Http\Requests\GastosOperativosComercializacionFormRequest;
use Session;

class GastosOperativosComercializacionCodeudorController extends Controller
{
    public $id_persona_codeudor;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if (session('id_persona_codeudor') == null) {
            alert()->info('Info', 'Seleccione un codeudor')->showConfirmButton();
            return redirect('oficial/codeudor/');
        } else {
            $gastos = GastosOperativosComercializacion::where('id_persona', session('id_persona_codeudor'))->where('id_credito', session('id_credito'))->get();
            return view('oficial.a_codeudores.gastos_operativos.index')->with(compact('gastos'));
        }

    }

    public function create()
    {
        if (session('id_persona_codeudor') == null) {
            alert()->info('Info', 'Seleccione un codeudor')->showConfirmButton();
            return redirect('oficial/codeudor/');
        } else {
            $if_exist = GastosOperativosComercializacion::where('id_persona', session('id_persona_codeudor'))->where('id_credito', session('id_credito'))->count();
            if ($if_exist > 0) {
                flash()->addWarning('Ya registro los datos de gastos Operativos.');
                return redirect('oficial/a_codeudores/gastos_operativos/');
            } else {
                return view('oficial.a_codeudores/gastos_operativos.create');
            }


        }

    }

    public function store(GastosOperativosComercializacionFormRequest $request)
    {
        $gastos = new GastosOperativosComercializacion();
        $gastos->combustible = $request->input('combustible');
        $gastos->deposito_almacen = $request->input('deposito_almacen');
        $gastos->energia_electrica = $request->input('energia_electrica');
        $gastos->agua = $request->input('agua');
        $gastos->gas = $request->input('gas');
        $gastos->telefono = $request->input('telefono');
        $gastos->impuestos = $request->input('impuestos');
        $gastos->alquiler = $request->input('alquiler');
        $gastos->cuidado_sereno = $request->input('cuidado_sereno');
        $gastos->transporte = $request->input('transporte');
        $gastos->mantenimiento = $request->input('mantenimiento');
        $gastos->publicidad = $request->input('publicidad');
        $gastos->otros = $request->input('otros');
        $gastos->detalle = $request->input('detalle');
        $gastos->id_persona = $request->input('id_persona');
        $gastos->id_credito = $request->input('id_credito');
        $gastos->save(); //metodo se encarga de ejecutar un insert sobre la tabla
        flash()->addSuccess('Registro Exitoso', 'El registro ha sido guardado correctamente');
        return redirect('oficial/a_codeudores/gastos_operativos');
    }

    public function edit($id)
    {
        $gastos = GastosOperativosComercializacion::find($id);
        return view('oficial.a_codeudores/gastos_operativos.edit')->with(compact('gastos')); //formulario de registro
    }

    public function update(GastosOperativosComercializacionFormRequest $request, $id)
    {
        $gastos = GastosOperativosComercializacion::find($id);
        $gastos->combustible = $request->input('combustible');
        $gastos->deposito_almacen = $request->input('deposito_almacen');
        $gastos->energia_electrica = $request->input('energia_electrica');
        $gastos->agua = $request->input('agua');
        $gastos->gas = $request->input('gas');
        $gastos->telefono = $request->input('telefono');
        $gastos->impuestos = $request->input('impuestos');
        $gastos->alquiler = $request->input('alquiler');
        $gastos->cuidado_sereno = $request->input('cuidado_sereno');
        $gastos->transporte = $request->input('transporte');
        $gastos->mantenimiento = $request->input('mantenimiento');
        $gastos->publicidad = $request->input('publicidad');
        $gastos->otros = $request->input('otros');
        $gastos->detalle = $request->input('detalle');
        $gastos->id_persona = $request->input('id_persona');
        $gastos->id_credito = $request->input('id_credito');
        $gastos->save(); //metodo se encarga de ejecutar un insert sobre la tabla
        flash()->addSuccess('Registro Exitoso', 'El registro ha sido guardado correctamente');
        return redirect('/oficial/a_codeudores/gastos_operativos');
    }
}
