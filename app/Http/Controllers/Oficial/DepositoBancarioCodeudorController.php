<?php

namespace sis5cs\Http\Controllers\Oficial;

use sis5cs\Http\Controllers\Controller;
use Illuminate\Http\Request;
use sis5cs\DepositoBancario;
use sis5cs\Persona;
use sis5cs\TipoDeposito;
use sis5cs\EntidadBancaria;
use sis5cs\Http\Requests\DepositoBancarioFormRequest;
use sis5cs\Http\Requests\PersonaFormRequest;
use DB;
use Fpdf;
use Auth;
use Alert;
use Session;

class DepositoBancarioCodeudorController extends Controller
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
            $deposito = DB::table('deposito_bancario')
                ->join('entidad_bancaria', 'deposito_bancario.id_entidad_bancaria', '=', 'entidad_bancaria.id_entidad_bancaria')
                ->join('tipo_deposito', 'deposito_bancario.id_tipo_deposito', '=', 'tipo_deposito.id_tipo_deposito')
                ->select('deposito_bancario.*', 'entidad_bancaria.nombre_entidad', 'tipo_deposito.nombre_deposito')
                ->where('id_persona', session('id_persona_codeudor'))
                ->where('id_credito', session('id_credito'))
                ->get();
            return view('oficial.a_codeudores.deposito_bancario.index')->with(compact('deposito'));
        }

    }

    public function create()
    {
        if (session('id_persona_codeudor') == null) {
            alert()->info('Info', 'Seleccione un codeudor')->showConfirmButton();
            return redirect('oficial/codeudor/');
        } else {
            $if_exist = DepositoBancario::where('id_persona', session('id_persona_codeudor'))->where('id_credito', session('id_credito'))->count();
            if ($if_exist >= 100) {
                flash()->addWarning('Ya registro Deposito Bancario.');
                return redirect('oficial/a_codeudores/deposito_bancario/');
            } else {
                $entidad = EntidadBancaria::all();
                $tipo = TipoDeposito::all();
                return view('oficial.a_codeudores.deposito_bancario.create')
                    ->with(compact('entidad', 'tipo'));
            }


        }

    }


    public function store(DepositoBancarioFormRequest $request)
    {
        $dep = new DepositoBancario();
        $dep->numero_cuenta = $request->input('numero_cuenta');
        $dep->saldo = $request->input('saldo');
        $dep->id_entidad_bancaria = $request->input('id_entidad_bancaria');
        $dep->id_tipo_deposito = $request->input('id_tipo_deposito');
        $dep->id_persona = $request->input('id_persona');
        $dep->id_credito = $request->input('id_credito');
        $dep->save(); //metodo se encarga de ejecutar un insert sobre la tabla
        flash()->addSuccess('Registro Exitoso', 'El registro ha sido guardado correctamente');
        return redirect('oficial/a_codeudores/deposito_bancario')->with(compact('notification'));
    }

    public function edit($id)
    {
        $dep = DepositoBancario::find($id);
        $entidad = EntidadBancaria::All();
        $tipo = TipoDeposito::All();
        return view('oficial.a_codeudores.deposito_bancario.edit')->with(compact('dep', 'tipo', 'entidad')); //formulario de registro
    }

    public function update(DepositoBancarioFormRequest $request, $id)
    {
        $dep = DepositoBancario::find($id);
        $dep->numero_cuenta = $request->input('numero_cuenta');
        $dep->saldo = $request->input('saldo');
        $dep->id_entidad_bancaria = $request->input('id_entidad_bancaria');
        $dep->id_tipo_deposito = $request->input('id_tipo_deposito');
        $dep->id_persona = $request->input('id_persona');
        $dep->id_credito = $request->input('id_credito');
        $dep->save(); //metodo se encarga de ejecutar un insert sobre la tabla
        flash()->addSuccess('Registro Exitoso', 'El registro ha sido guardado correctamente');
        return redirect('oficial/a_codeudores/deposito_bancario');
    }
}
