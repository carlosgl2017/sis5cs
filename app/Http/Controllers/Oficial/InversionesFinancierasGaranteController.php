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

class InversionesFinancierasGaranteController extends Controller
{
    public $id_persona_garante;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        //$this->id_persona=session('id_persona');
        if (session('id_persona_garante') == null) {
            alert()->info('Info', 'Seleccione un Garante')->showConfirmButton();
            return redirect('oficial/garante/');
        } else {
            $inversiones = InversionesFinancieras::where('id_persona', session('id_persona_garante'))->where('id_credito', session('id_credito'))->get();
            return view('oficial.a_garantes.inversiones_financieras.index')->with(compact('inversiones'));
        }

    }

    public function create()
    {
        if (session('id_persona_garante') == null) {
            alert()->info('Info', 'Seleccione un Garante')->showConfirmButton();
            return redirect('oficial/garante/');
        } else {

            $if_exist = InversionesFinancieras::where('id_persona', session('id_persona_garante'))->where('id_credito', session('id_credito'))->count();
            if ($if_exist > 100) {
                alert()->info('Info', 'Ya registro los datos de inversiones financieras')->showConfirmButton();
                return redirect('oficial/a_garantes/inversiones_financieras/');
            } else {
                return view('oficial.a_garantes.inversiones_financieras.create');
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
        $inversiones->id_persona =$request->input('id_persona');
        $inversiones->id_credito =$request->input('id_credito');
        $inversiones->save(); //metodo se encarga de ejecutar un insert sobre la tabla
        $notification = 'Exelente los datos se han guardado correctamente';
        return redirect('oficial/a_garantes/inversiones_financieras')->with(compact('notification'));
    }

    public function edit($id)
    {
        $inversiones = InversionesFinancieras::find($id);
        return view('oficial.a_garantes/inversiones_financieras.edit')->with(compact('inversiones')); //formulario de registro
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
        $inversiones->id_persona =$request->input('id_persona');
        $inversiones->id_credito =$request->input('id_credito');
        $inversiones->save(); //metodo se encarga de ejecutar un insert sobre la tabla
        $notification = 'Exelente los datos se han modificado correctamente';
        return redirect('oficial/a_garantes/inversiones_financieras')->with(compact('notification'));
    }
}
