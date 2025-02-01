<?php

namespace sis5cs\Http\Controllers\Oficial;

use sis5cs\Http\Controllers\Controller;
use Illuminate\Http\Request;
use sis5cs\CuentasPorPagar;
use sis5cs\Persona;
use sis5cs\Http\Requests\CuentasPagarFormRequest;
use sis5cs\Http\Requests\PersonaFormRequest;
use DB;
use Session;

class CuentasPagarCodeudorController extends Controller
{
    public $id_persona_codeudor;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $this->id_persona_codeudor = session('id_persona_codeudor');
        if (session('id_persona_codeudor') == null) {
            flash()->addWarning('Seleccione un Codeudor');
            return redirect('oficial/codeudor/');
        } else {

            $pagar = CuentasPorPagar::where('id_persona', session('id_persona_codeudor'))->where('id_credito', session('id_credito'))->get();
            return view('oficial.a_codeudores.cuentas_por_pagar.index')->with(compact('pagar'));

        }

    }

    public function create()
    {
        if (session('id_persona_codeudor') == null) {
            flash()->addWarning('Seleccione un Codeudor');
            return redirect('oficial/codeudor/');
        } else {
            $if_exist = CuentasPorPagar::where('id_persona', session('id_persona_codeudor'))->where('id_credito', session('id_credito'))->count();
            if ($if_exist > 100) {
                alert()->info('Info', 'Ya registro las datos de cuentas por pagar')->showConfirmButton();
                return redirect('oficial/a_codeudores/cuentas_por_pagar/');
            } else {
                return view('oficial.a_codeudores.cuentas_por_pagar.create');
            }
        }
    }

    public function store(CuentasPagarFormRequest $request)
    {
        $in = new CuentasPorPagar();
        $in->institucion = $request->input('institucion');
        $in->tiempo = $request->input('tiempo');
        $in->cuota_mensual = $request->input('cuota_mensual');
        $in->saldo = $request->input('saldo');
        $in->id_persona = $request->input('id_persona');
        $in->id_credito = $request->input('id_credito');
        $in->save(); //metodo se encarga de ejecutar un insert sobre la tabla return redirect('oficial/direccion');
        flash()->addSuccess('Registro Exitoso', 'El registro ha sido guardado correctamente');
        return redirect('oficial/a_codeudores/cuentas_por_pagar');
    }

    public function edit($id)
    {
        $cuentas = CuentasPorPagar::find($id);
        return view('oficial.a_codeudores.cuentas_por_pagar.edit')->with(compact('cuentas')); //formulario de registro
    }

    public function update(CuentasPagarFormRequest $request, $id)
    {
        $cuentas = CuentasPorPagar::find($id);
        $cuentas->institucion = $request->input('institucion');
        $cuentas->tiempo = $request->input('tiempo');
        $cuentas->cuota_mensual = $request->input('cuota_mensual');
        $cuentas->saldo = $request->input('saldo');
        $cuentas->id_persona = $request->input('id_persona');
        $cuentas->id_credito = $request->input('id_credito');
        $cuentas->save(); //metodo se encarga de ejecutar un insert sobre la tabla
        flash()->addSuccess('Registro Exitoso', 'El registro ha sido guardado correctamente');
        return redirect('oficial/a_codeudores/cuentas_por_pagar/');
    }

}
