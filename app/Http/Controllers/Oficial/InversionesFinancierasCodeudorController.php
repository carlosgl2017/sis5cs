<?php

namespace sis5cs\Http\Controllers\Oficial;

use sis5cs\Http\Controllers\Controller;
use Illuminate\Http\Request;

use sis5cs\Http\Requests\InversionesFinancierasFormRequest;
use sis5cs\InversionesFinancieras;
use sis5cs\TipoVivienda;
use sis5cs\Persona;
use Session;
use DB;
use Fpdf;
use Auth;
use Alert;

class InversionesFinancierasCodeudorController extends Controller
{
    public $id_persona_codeudor;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if (session('id_persona_codeudor') == null) {
            alert()->info('Info', 'Seleccione un Codeudor')->showConfirmButton();
            return redirect('oficial/codeudor/');
        } else {
            $inversiones = InversionesFinancieras::where('id_persona', session('id_persona_codeudor'))->where('id_credito', session('id_credito'))->get();
            return view('oficial.a_codeudores.inversiones_financieras.index')->with(compact('inversiones'));

        }

    }

    public function create()
    {
        if (session('id_persona_codeudor') == null) {
            alert()->info('Info', 'Seleccione un codeudor')->showConfirmButton();
            return redirect('oficial/codeudor/');
        } else {

            $if_exist = InversionesFinancieras::where('id_persona', session('id_persona_codeudor'))->where('id_credito', session('id_credito'))->count();
            if ($if_exist > 100) {
                flash()->addWarning('Ya registro los datos de inversiones financieras');
                return redirect('oficial/a_codeudores/inversiones_financieras/');
            } else {
                return view('oficial.a_codeudores.inversiones_financieras.create');
            }
        }
    }

    public function store(InversionesFinancierasFormRequest $request)
    {
        $inversiones = new InversionesFinancieras();
        $inversiones->cantidad = $request->input('cantidad');
        $inversiones->porcentaje_patrimonio_empre = $request->input('porcentaje_patrimonio_empre');
        $inversiones->nit = $request->input('nit');
        $inversiones->nombre_empresa = $request->input('nombre_empresa');
        $inversiones->valor_nominal = $request->input('valor_nominal');
        $inversiones->valor_mercado = $request->input('valor_mercado');
        $inversiones->detalle = $request->input('detalle');
        $inversiones->id_persona = $request->input('id_persona');
        $inversiones->id_credito = $request->input('id_credito');
        $inversiones->save(); //metodo se encarga de ejecutar un insert sobre la tabla
        flash()->addSuccess('Registro Exitoso', 'El registro ha sido guardado correctamente');
        return redirect('oficial/a_codeudores/inversiones_financieras');
    }

    public function edit($id)
    {
        $inversiones = InversionesFinancieras::find($id);
        return view('oficial.a_codeudores.inversiones_financieras.edit')->with(compact('inversiones')); //formulario de registro
    }

    public function update(InversionesFinancierasFormRequest $request, $id)
    {
        $inversiones = InversionesFinancieras::find($id);
        $inversiones->cantidad = $request->input('cantidad');
        $inversiones->porcentaje_patrimonio_empre = $request->input('porcentaje_patrimonio_empre');
        $inversiones->nit = $request->input('nit');
        $inversiones->nombre_empresa = $request->input('nombre_empresa');
        $inversiones->valor_nominal = $request->input('valor_nominal');
        $inversiones->valor_mercado = $request->input('valor_mercado');
        $inversiones->detalle = $request->input('detalle');
        $inversiones->id_persona = $request->input('id_persona');
        $inversiones->id_credito = $request->input('id_credito');
        $inversiones->save(); //metodo se encarga de ejecutar un insert sobre la tabla
        flash()->addSuccess('Registro Exitoso', 'El registro ha sido guardado correctamente');
        return redirect('oficial/a_codeudores/inversiones_financieras');
    }

}
