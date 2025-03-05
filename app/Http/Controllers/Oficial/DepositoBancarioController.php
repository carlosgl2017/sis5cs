<?php

namespace sis5cs\Http\Controllers\Oficial;

use Alert;
use DB;
use Illuminate\Http\Request;
use Session;
use sis5cs\DepositoBancario;
use sis5cs\EntidadBancaria;
use sis5cs\Http\Controllers\Controller;
use sis5cs\Http\Requests\DepositoBancarioFormRequest;
use sis5cs\TipoDeposito;

class DepositoBancarioController extends Controller
{
    public $id_persona;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if (session('id_persona') == null) {
            flash()->addWarning('Seleccione un crédito.');
            return redirect('oficial/dashboard/');
        } else {
            $deposito = DB::table('deposito_bancario')
                ->join('entidad_bancaria', 'deposito_bancario.id_entidad_bancaria', '=', 'entidad_bancaria.id_entidad_bancaria')
                ->join('tipo_deposito', 'deposito_bancario.id_tipo_deposito', '=', 'tipo_deposito.id_tipo_deposito')
                ->select('deposito_bancario.*', 'entidad_bancaria.nombre_entidad', 'tipo_deposito.nombre_deposito')
                ->where('id_persona', session('id_persona'))
                ->where('id_credito', session('id_credito'))
                ->get();
            return view('oficial.deposito_bancario.index')->with(compact('deposito'));
        }

    }

    public function create()
    {
        if (session('id_persona') == null) {
            flash()->addWarning('Seleccione un crédito.');
            return redirect('oficial/dashboard/');
        } else {
            $if_exist = DepositoBancario::where('id_persona', session('id_persona'))->where('id_credito', session('id_credito'))->count();
            if ($if_exist >= 100) {
                alert()->info('Info', 'Ya registro Deposito Bancario.')->showConfirmButton();
                return redirect('oficial/deposito_bancario/');
            } else {
                $entidad = EntidadBancaria::all();
                $tipo = TipoDeposito::all();
                return view('oficial.deposito_bancario.create')
                    ->with(compact('entidad', 'tipo'));
            }

        }

    }

    public function store(DepositoBancarioFormRequest $request)
    {
        $dep = new DepositoBancario();
        $dep->numero_cuenta = $request->input('numero_cuenta');
        $dep->detalle = $request->input('detalle');
        $dep->saldo = $request->input('saldo');
        $dep->id_entidad_bancaria = $request->input('id_entidad_bancaria');
        $dep->id_tipo_deposito = $request->input('id_tipo_deposito');
        $dep->id_persona =  $request->input('id_persona');
        $dep->id_credito =  $request->input('id_credito');
        $dep->save(); //metodo se encarga de ejecutar un insert sobre la tabla
        flash()->addSuccess('Registro Exitoso', 'El registro ha sido guardado');
        return redirect('oficial/deposito_bancario');
    }

    public function edit($id)
    {
        $dep = DepositoBancario::find($id);
        $entidad = EntidadBancaria::All();
        $tipo = TipoDeposito::All();
        return view('oficial.deposito_bancario.edit')->with(compact('dep', 'tipo', 'entidad')); //formulario de registro
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'numero_cuenta' => 'required|numeric',
            'detalle' => 'required|string',
            'saldo' => 'numeric|required',
            'id_entidad_bancaria' => 'numeric|required',
            'id_tipo_deposito' => 'numeric|required'
            // Agrega las reglas de validación necesarias según tu modelo
        ]);

        // Buscar el modelo; si no existe, lanzar un 404
        $dep = DepositoBancario::findOrFail($id);

        // Actualizar usando los datos validados
        $dep->update($validatedData);
        flash()->addSuccess('Registro modificado', 'El registro ha sido modificado');
        return redirect('oficial/deposito_bancario');
    }

}
