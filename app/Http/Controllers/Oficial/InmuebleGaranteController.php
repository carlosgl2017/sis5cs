<?php

namespace sis5cs\Http\Controllers\Oficial;

use Illuminate\Http\Request;
use Session;
use sis5cs\Http\Controllers\Controller;
use sis5cs\Http\Requests\InmuebleFormRequest;
use sis5cs\Inmueble;

class InmuebleGaranteController extends Controller
{
    public $id_persona_garante;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if (session('id_persona_garante') == null) {
            alert()->info('Info', 'Seleccione un Garante')->showConfirmButton();
            return redirect('oficial/garante/');
        } else {
            $inmuebles = Inmueble::where('id_persona', session('id_persona_garante'))->where('id_credito', session('id_credito'))->get();
            return view('oficial.a_garantes.inmueble.index')->with(compact('inmuebles'));

        }

    }

    public function create()
    {
        if (session('id_persona') == null) {
            alert()->info('Info', 'Seleccione un garante')->showConfirmButton();
            return redirect('oficial/garante/');
        } else {
            $inmuebles = Inmueble::all();
            return view('oficial.a_garantes.inmueble.create')
                ->with(compact('inmuebles'));
        }
    }

    public function store(InmuebleFormRequest $request)
    {
        $in = new Inmueble();
        $in->ciudad = $request->input('ciudad');
        $in->calle = $request->input('calle');
        $in->numero = $request->input('numero');
        $in->zona = $request->input('zona');
        $in->num_folio_real = $request->input('num_folio_real');
        $in->fecha_registro = $request->input('fecha_registro');
        $in->en_garantia = $request->input('en_garantia');
        $in->detalle = $request->input('detalle');
        $in->valor = $request->input('valor');
        $in->id_persona = $request->input('id_persona');
        $in->id_credito = $request->input('id_credito');
        $in->save(); //metodo se encarga de ejecutar un insert sobre la tabla return redirect('oficial/direccion');
        flash()->addSuccess('Registro Exitoso', 'El registro ha sido guardado correctamente');
        return redirect('oficial/a_garantes/inmueble');
    }

    public function edit($id)
    {
        $in = Inmueble::find($id);
        return view('oficial.a_garantes.inmueble.edit')->with(compact('in')); //formulario de registro
    }

    public function update(InmuebleFormRequest $request, $id)
    {
        $in = Inmueble::find($id);
        $in->ciudad = $request->input('ciudad');
        $in->calle = $request->input('calle');
        $in->numero = $request->input('numero');
        $in->zona = $request->input('zona');
        $in->num_folio_real = $request->input('num_folio_real');
        $in->fecha_registro = $request->input('fecha_registro');
        $in->en_garantia = $request->input('en_garantia');
        $in->detalle = $request->input('detalle');
        $in->valor = $request->input('valor');
        $in->id_persona = $request->input('id_persona');
        $in->id_credito = $request->input('id_credito');
        $in->save(); //metodo se encarga de ejecutar un insert sobre la tabla
        flash()->addSuccess('Registro Exitoso', 'El registro ha sido guardado correctamente');
        return redirect('oficial/a_garantes/inmueble');
    }
}
