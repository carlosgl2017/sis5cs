<?php

namespace sis5cs\Http\Controllers\Oficial;

use Maatwebsite\Excel\Facades\Excel;
use sis5cs\Imports\IngresoMensualCodeudorImport;
use sis5cs\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use sis5cs\Http\Requests\IngresoMensualFormRequest;
use sis5cs\IngresoMensual;

class IngresoMensualCodeudorController extends Controller
{
//variables de clase
    public $id_persona_codeudor;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (session('id_persona_codeudor') == null) {
            flash()->addWarning('Seleccione un Codeudor');
            return redirect('oficial/codeudor/');
        } else {
            $ingreso = IngresoMensual::where('id_persona', session('id_persona_codeudor'))->where('id_credito', session('id_credito'))->get();
            return view('oficial.a_codeudores.ingreso_mensual.index')->with(compact('ingreso'));
        }

    }

    public function import(Request $request)
    {
        if (session($this->id_persona_codeudor) == null) {
            flash()->addWarning('Seleccione un Codeudor');
            return redirect('oficial/dashboard/');
        } else {
            $file = $request->file('ingreso_mensual');
            Excel::import(new IngresoMensualCodeudorImport, $file);
            $ingreso = IngresoMensual::where('id_persona', session('id_persona_codeudor'))->get();
            flash()->addSuccess('Carga Exitosa', 'Se ha cargado correctamente el archivo');
            return view('oficial.a_codeudores.ingreso_mensual.index')->with(compact('ingreso'));
        }

    }

    public function create()
    {
        if (session('id_persona_codeudor') == null) {
            flash()->addWarning('Seleccione un Codeudor');
            return redirect('oficial/codeudor/');
        } else {
            $if_exist = IngresoMensual::where('id_persona', session('id_persona_codeudor'))->where('id_credito', session('id_credito'))->count();
            if ($if_exist > 2) {
                flash()->addWarning('Ya resgistro ingreso mensual');;
                return redirect('oficial/a_codeudores/ingreso_mensual/');
            } else {
                return view('oficial.a_codeudores.ingreso_mensual.create');
            }
        }


    }

    public function edit($id)
    {
        if (session('id_persona_codeudor') == null) {
            alert()->info('Info', 'Seleccione un codeudor')->showConfirmButton();
            return redirect('oficial/codeudor/');
        } else {
            $ingresos = IngresoMensual::find($id);
            return view('oficial.a_codeudores.ingreso_mensual.edit')->with(compact('ingresos')); //formulario de registro
        }
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'mes' => 'string',
            'anio' => 'numeric',
            'prestatario' => 'numeric',
            'conyugue' => 'numeric|nullable',
            'otros' => 'numeric|nullable',
            'codeudores' => 'numeric|nullable'
        ]);
        $this->id_persona_codeudor = session('id_persona_codeudor');
        $ingre = IngresoMensual::find($id);
        $ingre->mes = $request->input('mes');
        $ingre->anio = $request->input('anio');
        $ingre->prestatario = $request->input('prestatario');
        $ingre->conyugue = $request->input('conyugue');
        $ingre->otros = $request->input('otros');
        $ingre->codeudores = $request->input('codeudores');
        $ingre->total_ingreso = $request->input('prestatario') + $request->input('conyugue') + $request->input('otros') + $request->input('codeudores');
        $ingre->descripcion = $request->input('descripcion');
        $ingre->id_persona = $this->id_persona_codeudor;
        $ingre->save(); //metodo se encarga de ejecutar un insert sobre la tabla
        return redirect('/oficial/a_codeudores/ingreso_mensual/');
    }

    public function download()
    {
        $pathtoFile = public_path() . '/plantillas_excel/template_ingreso_mensual.xlsx';
        return response()->download($pathtoFile);
    }
}
