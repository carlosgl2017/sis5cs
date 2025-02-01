<?php

namespace sis5cs\Http\Controllers\Oficial;

use sis5cs\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Session;
use sis5cs\Http\Requests\OtroActivoFormRequest;
use sis5cs\OtroActivo;
use sis5cs\Persona;

class OtroActivoController extends Controller
{
    public $id_persona;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if (session('id_persona') == null||session('id_credito') == null) {
            alert()->info('Info', 'Seleccione un Socio y credito')->showConfirmButton();
            return redirect('oficial/dashboard/');
        } else {
            $activo = OtroActivo::where('id_persona', session('id_persona'))->where('id_credito', session('id_credito'))->get();
            return view('oficial.otros_activos.index')->with(compact('activo'));
        }
    }
    public function create()
    {
        if (session('id_persona') == null||session('id_credito') == null) {
            alert()->info('Info', 'Seleccione un socio y crédito')->showConfirmButton();
            return redirect('oficial/dashboard/');
        } else {
            return view('oficial.otros_activos.create');
        }
    }

    public function store(OtroActivoFormRequest $request)
    {
        $ac = new OtroActivo();
        $ac->detalle = $request->input('detalle');
        $ac->en_garantia = $request->input('en_garantia');
        $ac->total = $request->input('total');
        $ac->id_persona =  $request->input('id_persona');
        $ac->id_credito =  $request->input('id_credito');
        $ac->save(); //metodo se encarga de ejecutar un insert sobre la tabla
        flash()->addSuccess('Registro Exitoso', 'El registro ha sido guardado correctamente');
        return redirect('oficial/otros_activos');
    }

    public function edit($id)
    {
        $activo = OtroActivo::find($id);
        return view('oficial.otros_activos.edit')->with(compact('activo')); //formulario de registro
    }

    public function update(OtroActivoFormRequest $request, $id)
    {
        $ac = OtroActivo::find($id);
        $ac->detalle = $request->input('detalle');
        $ac->en_garantia = $request->input('en_garantia');
        $ac->total = $request->input('total');
        $ac->id_persona =  $request->input('id_persona');
        $ac->id_credito =  $request->input('id_credito');
        $ac->save(); //metodo se encarga de ejecutar un insert sobre la tabla
        flash()->addSuccess('Registro Exitoso', 'El registro ha sido guardado correctamente');
        return redirect('oficial/otros_activos');
    }


}
