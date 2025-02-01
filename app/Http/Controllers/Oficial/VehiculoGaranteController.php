<?php

namespace sis5cs\Http\Controllers\Oficial;

use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Session;
use sis5cs\Http\Controllers\Controller;
use sis5cs\Http\Requests\VehiculoFormRequest;
use sis5cs\Vehiculo;

class VehiculoGaranteController extends Controller
{
    public $id_persona_garante;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $this->id_persona_garante =session('id_persona_garante');
        if (session('id_persona_garante') == null) {
            alert()->info('Info', 'Seleccione un Garante')->showConfirmButton();
            return redirect('oficial/garante/');
        } else {
            $vehiculos = Vehiculo::where('id_persona',session('id_persona_garante'))->where('id_credito',session('id_credito'))->get();
            return view('oficial.a_garantes.vehiculo.index')->with(compact('vehiculos'));

        }

    }

    public function create()
    {
        if (session('id_persona_garante') == null) {
            alert()->info('Info', 'Seleccione un garante')->showConfirmButton();
            return redirect('oficial/garante/');
        } else {
            $vehiculos = Vehiculo::all();
            return view('oficial.a_garantes.vehiculo.create')
                ->with(compact('vehiculos'));
        }
    }

    public function store(VehiculoFormRequest $request)
    {
        $vehi = new Vehiculo();
        $vehi->tipo = $request->input('tipo');
        $vehi->marca = $request->input('marca');
        $vehi->modelo = $request->input('modelo');
        $vehi->placa = $request->input('placa');
        $vehi->rua = $request->input('rua');
        $vehi->en_garantia = $request->input('en_garantia');
        $vehi->detalle = $request->input('detalle');
        $vehi->valor = $request->input('valor');
        $vehi->id_persona =  $request->input('id_persona');
        $vehi->id_credito =  $request->input('id_credito');
        $vehi->save(); //metodo se encarga de ejecutar un insert sobre la tabla
        flash()->addSuccess('Registro Exitoso', 'El registro ha sido guardado correctamente');
        return redirect('/oficial/a_garantes/vehiculo');
    }

    public function edit($id)
    {
        $vehiculo = Vehiculo::find($id);
        return view('oficial.a_garantes.vehiculo.edit')->with(compact('vehiculo')); //formulario de registro
    }

    public function update(VehiculoFormRequest $request, $id)
    {
        $vehi = Vehiculo::find($id);
        $vehi->tipo = $request->input('tipo');
        $vehi->marca = $request->input('marca');
        $vehi->modelo = $request->input('modelo');
        $vehi->placa = $request->input('placa');
        $vehi->rua = $request->input('rua');
        $vehi->en_garantia = $request->input('en_garantia');
        $vehi->detalle = $request->input('detalle');
        $vehi->valor = $request->input('valor');
        $vehi->id_persona =  $request->input('id_persona');
        $vehi->id_credito =  $request->input('id_credito');
        $vehi->save(); //metodo se encarga de ejecutar un insert sobre la tabla
        flash()->addSuccess('Registro Exitoso', 'El registro ha sido guardado correctamente');
        return redirect('/oficial/a_garantes/vehiculo');
    }

}
