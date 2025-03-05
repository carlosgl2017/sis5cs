<?php

namespace sis5cs\Http\Controllers\Oficial;

use Maatwebsite\Excel\Facades\Excel;
use sis5cs\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use sis5cs\Http\Requests\IngresoMensualFormRequest;
use sis5cs\Imports\IngresoMensualImport;
use sis5cs\IngresoMensual;

class IngresoMensualController extends Controller
{
    //variables de clase
    public $id_persona;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (session('id_persona') == null||session('id_credito')==null) {
            alert()->info('Info', 'Seleccione un socio y credito')->showConfirmButton();
            return redirect('oficial/dashboard/');
        } else {
            $ingreso = IngresoMensual::where('id_persona', session('id_persona'))->where('id_credito', session('id_credito'))->get();
            return view('oficial.ingreso_mensual.index')->with(compact('ingreso'));
        }

    }

    public function import(Request $request)
    {
        $this->id_persona = session('id_persona');
        $this->id_credito = session('id_credito');
        if ($this->id_persona == null) {
            flash()->addWarning('Seleccione un crédito.');
            return redirect('oficial/dashboard/');
        } else {
            $file = $request->file('ingreso_mensual');
            Excel::import(new IngresoMensualImport, $file);
            $ingreso = IngresoMensual::where('id_persona', $this->id_persona)->where('id_credito', session('id_credito'))->get();
            alert()->info('Info', 'Se realizó la carga de datos correctamente')->showConfirmButton();
            return view('oficial.ingreso_mensual.index')->with(compact('ingreso'));
        }
    }

    public function create()
    {
        if (session('id_persona') == null||session('id_credito')==null) {
            alert()->info('Info', 'Seleccione un socio y crédito')->showConfirmButton();
            return redirect('oficial/dashboard/');
        } else {
            $if_exist = IngresoMensual::where('id_persona', session('id_persona'))->where('id_credito', session('id_credito'))->count();
            if ($if_exist > 2) {
                flash()->addWarning('Ya redistro el ingreso mensual');
                return redirect('oficial/ingreso_mensual/');
            } else {
                return view('oficial.ingreso_mensual.create');
            }
        }
    }

    public function edit($id)
    {
        if (session('id_persona') == null) {
            flash()->addWarning('Seleccione un crédito.');
            return redirect('oficial/dashboard/');
        } else {
            $ingresos = IngresoMensual::find($id);
            return view('oficial.ingreso_mensual.edit')->with(compact('ingresos')); //formulario de registro
        }
    }

    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'mes' => 'string',
            'anio' => 'numeric',
            'prestatario' => 'numeric|nullable',
            'conyugue' => 'numeric|nullable',
            'otros' => 'numeric|nullable',
            'codeudores' => 'numeric|nullable'
        ]);
        $ingre = IngresoMensual::find($id);
        $ingre->mes = $request->input('mes');
        $ingre->anio = $request->input('anio');
        $ingre->prestatario = $request->input('prestatario');
        $ingre->conyugue = $request->input('conyugue');
        $ingre->otros = $request->input('otros');
        $ingre->codeudores = $request->input('codeudores');
        $ingre->total_ingreso = $request->input('prestatario') + $request->input('conyugue') + $request->input('otros') + $request->input('codeudores');
        $ingre->descripcion = $request->input('descripcion');
        $ingre->id_persona = $request->input('id_persona');
        $ingre->id_credito = $request->input('id_credito');
        $ingre->save(); //metodo se encarga de ejecutar un insert sobre la tabla
        return redirect('/oficial/ingreso_mensual/');
    }

    public function download()
    {
        $pathtoFile = public_path() . '/plantillas_excel/template_ingreso_mensual.xlsx';
        return response()->download($pathtoFile);
    }
}
