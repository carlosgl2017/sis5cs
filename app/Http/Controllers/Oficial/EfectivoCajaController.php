<?php

namespace sis5cs\Http\Controllers\Oficial;

use sis5cs\Http\Controllers\Controller;
use Illuminate\Http\Request;
use sis5cs\Http\Requests\EfectivoCajaFormRequest;
use sis5cs\EfectivoCaja;
use sis5cs\Persona;
use Session;

class EfectivoCajaController extends Controller
{
    public $id_persona;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if (session('id_persona') == null||session('id_credito')==null) {
            alert()->info('Info', 'Seleccione un Socio y Crédito')->showConfirmButton();
            return redirect('oficial/dashboard/');
        } else {
            $efectivo = EfectivoCaja::where('id_persona', session('id_persona'))->where('id_credito', session('id_credito'))->get();
            return view('oficial.efectivos_caja.index')->with(compact('efectivo'));
        }

    }

    public function create()
    {
        if (session('id_persona') == null) {
            flash()->addWarning('Seleccione un crédito.');
            return redirect('oficial/dashboard/');
        } else {

            $if_exist = EfectivoCaja::where('id_persona', session('id_persona'))->where('id_persona', session('id_credito'))->count();
            if ($if_exist > 0) {
                alert()->info('Info', 'Ya registro las datos de efectivos en caja')->showConfirmButton();
                return redirect('oficial/efectivos_caja/');
            } else {
                return view('oficial.efectivos_caja.create');
            }

        }
    }

    public function store(EfectivoCajaFormRequest $request)
    {
        $efectivo = new EfectivoCaja();
        $efectivo->caja = $request->input('caja');
        $efectivo->id_persona = $request->input('id_persona');
        $efectivo->id_credito = $request->input('id_credito');
        $efectivo->save(); //metodo se encarga de ejecutar un insert sobre la tabla
        flash()->addSuccess('Registro Exitoso', 'El registro ha sido guardado correctamente');
        return redirect('oficial/efectivos_caja');
    }

    public function edit($id)
    {
        $efe = EfectivoCaja::find($id);
        return view('oficial.efectivos_caja.edit')->with(compact('efe')); //formulario de registro
    }

    public function update(EfectivoCajaFormRequest $request, $id)
    {
        $efe = EfectivoCaja::find($id);
        $efe->caja = $request->input('caja');
        $efe->id_persona = $request->input('id_persona');
        $efe->id_credito = $request->input('id_credito');
        $efe->save(); //metodo se encarga de ejecutar un insert sobre la tabla
        $notification = 'Exelente sus datos se han modificado correctamente';
        return redirect('oficial/efectivos_caja/')->with(compact('notification'));

    }
}

