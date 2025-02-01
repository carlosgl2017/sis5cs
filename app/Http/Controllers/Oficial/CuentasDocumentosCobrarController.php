<?php

namespace sis5cs\Http\Controllers\Oficial;

use sis5cs\Http\Controllers\Controller;
use Illuminate\Http\Request;
use sis5cs\Persona;
use sis5cs\CuentasDocumentosCobrar;
use sis5cs\TipoDeposito;
use sis5cs\Http\Requests\CuentasDocumentosCobrarFormRequest;
use sis5cs\User;
use DB;
use Fpdf;
use Auth;
use Alert;
use Session;

class CuentasDocumentosCobrarController extends Controller
{
    public $id_persona;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $this->id_persona = session('id_persona');
        if (session('id_persona') == null||session('id_credito')==null) {
            alert()->info('Info', 'Seleccione un Socio o Crédito')->showConfirmButton();
            return redirect('oficial/dashboard/');
        } else {

            $cuentas = CuentasDocumentosCobrar::where('id_persona', session('id_persona'))->where('id_persona', session('id_persona'))->get();
            return view('oficial.cuentas_documentos_cobrar.index')->with(compact('cuentas'));

        }

    }

    public function create()
    {
        if (session('id_persona') == null) {
            alert()->info('Info', 'Seleccione un Socio')->showConfirmButton();
            return redirect('oficial/dashboard/');
        } else {
            $if_exist = CuentasDocumentosCobrar::where('id_persona', session('id_persona'))->count();
            if ($if_exist > 100) {
                alert()->info('Info', 'Ya registro las datos de cuentas documentos cobrar')->showConfirmButton();
                return redirect('oficial/cuentas_documentos_cobrar/');
            } else {
                return view('oficial.cuentas_documentos_cobrar.create');
            }
        }
    }

    public function store(CuentasDocumentosCobrarFormRequest $request)
    {
        $this->id_persona = session('id_persona');
        $cuentas = new CuentasDocumentosCobrar();
        $cuentas->nit = $request->input('nit');
        $cuentas->nombre_razon_social = $request->input('nombre_razon_social');
        $cuentas->concepto = $request->input('concepto');
        $cuentas->saldo = $request->input('saldo');
        $cuentas->id_persona = $request->input('id_persona');
        $cuentas->id_credito = $request->input('id_credito');
        $cuentas->save(); //metodo se encarga de ejecutar un insert sobre la tabla return redirect('oficial/direccion');
        flash()->addSuccess('Registro Exitoso', 'El registro ha sido guardado correctamente');
        return redirect('oficial/cuentas_documentos_cobrar');
    }

    public function edit($id)
    {
        $cuentas = CuentasDocumentosCobrar::find($id);
        return view('oficial.cuentas_documentos_cobrar.edit')->with(compact('cuentas')); //formulario de registro
    }

    public function update(CuentasDocumentosCobrarFormRequest $request, $id)
    {
        $cuentas = CuentasDocumentosCobrar::find($id);
        $cuentas->nit = $request->input('nit');
        $cuentas->nombre_razon_social = $request->input('nombre_razon_social');
        $cuentas->concepto = $request->input('concepto');
        $cuentas->saldo = $request->input('saldo');
        $cuentas->id_persona = $request->input('id_persona');
        $cuentas->id_credito = $request->input('id_credito');
        $cuentas->save(); //metodo se encarga de ejecutar un insert sobre la tabla
        flash()->addSuccess('Registro Exitoso', 'El registro ha sido guardado correctamente');
        return redirect('oficial/cuentas_documentos_cobrar/');
    }

}
