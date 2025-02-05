<?php

namespace sis5cs\Http\Controllers\Oficial;

use Maatwebsite\Excel\Facades\Excel;
use sis5cs\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use sis5cs\Http\Requests\IngresoMensualFormRequest;
use sis5cs\Imports\IngresoMensualGaranteImport;

use sis5cs\IngresoMensual;

class IngresoMensualGaranteController extends Controller
{
    //variables de clase
    public $id_persona_garante;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (session('id_persona_garante') == null) {
            alert()->info('Info', 'Seleccione un garante')->showConfirmButton();
            return redirect('oficial/garante/');
        } else {
            $ingreso = IngresoMensual::where('id_persona', session('id_persona_garante'))->where('id_credito', session('id_credito'))->get();
            return view('oficial.a_garantes.ingreso_mensual.index')->with(compact('ingreso'));
        }
    }

    public function import(Request $request)
    {
        $this->id_persona_garante = session('id_persona_garante');
        if ($this->id_persona_garante == null) {
            alert()->info('Info', 'Seleccione a un garante')->showConfirmButton();
            return redirect('oficial/dashboard/');
        } else {
            $file = $request->file('ingreso_mensual');
            Excel::import(new IngresoMensualGaranteImport, $file);
            $ingreso = IngresoMensual::where('id_persona', session('id_persona_garante'))->where('id_credito', session('id_credito'))->get();
            flash()->addSuccess('Registro Exitoso', 'Los registros se han cargado correctamente');
            return view('oficial.a_garantes.ingreso_mensual.index')->with(compact('ingreso'));
        }

    }

    public function create()
    {
        if (session('id_persona_garante') == null) {
            alert()->info('Info', 'Seleccione un Garante')->showConfirmButton();
            return redirect('oficial/garante/');
        } else {
            $if_exist = IngresoMensual::where('id_persona', session('id_persona_garante'))->where('id_credito', session('id_credito'))->count();
            if ($if_exist > 2) {
                alert()->info('Info', 'Ya registro los datos de ingreso mensual')->showConfirmButton();
                return redirect('oficial/a_garantes/ingreso_mensual/');
            } else {
                return view('oficial.a_garantes.ingreso_mensual.create');
            }
        }
    }

    public function edit($id)
    {
        if (session('id_persona_garante') == null) {
            alert()->info('Info', 'Seleccione un garante')->showConfirmButton();
            return redirect('oficial/garante/');
        } else {
            $ingresos = IngresoMensual::find($id);
            return view('oficial.a_garantes.ingreso_mensual.edit')->with(compact('ingresos')); //formulario de registro
        }
    }

    public function update(IngresoMensualFormRequest $request, $id)
    {
        $this->id_persona_garante = session('id_persona_garante');
        $ingre = IngresoMensual::find($id);
        $ingre->mes = $request->input('mes');
        $ingre->anio = $request->input('anio');
        $ingre->prestatario = $request->input('prestatario');
        $ingre->conyugue = $request->input('conyugue');
        $ingre->otros = $request->input('otros');
        $ingre->codeudores = $request->input('codeudores');
        $ingre->total_ingreso = $request->input('prestatario') + $request->input('conyugue') + $request->input('otros') + $request->input('codeudores');
        $ingre->descripcion = $request->input('descripcion');
        $ingre->id_persona = $this->id_persona_garante;
        $ingre->save(); //metodo se encarga de ejecutar un insert sobre la tabla
        return redirect('/oficial/a_garantes/ingreso_mensual/');
    }

    public function download()
    {
        $pathtoFile = public_path() . '/plantillas_excel/template_ingreso_mensual.xlsx';
        return response()->download($pathtoFile);
    }
}
