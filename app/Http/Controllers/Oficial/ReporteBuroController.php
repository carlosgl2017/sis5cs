<?php

namespace sis5cs\Http\Controllers\Oficial;

use Alert;
use DB;
use Illuminate\Http\Request;
use Session;
use sis5cs\Buro;
use sis5cs\Http\Controllers\Controller;
use sis5cs\Http\Requests\ReporteBuroFormRequest;
use sis5cs\ReporteBuro;

class ReporteBuroController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {

        if (session('id_persona') == null) {
            alert()->info('Info', 'Seleccione un socio')->showConfirmButton();
            return redirect('oficial/dashboard/');
        } else {
            $reporte_buro = DB::table('reporte_buro')
                ->join('buros', 'reporte_buro.id_buro', '=', 'buros.id_buro')
                ->select('reporte_buro.*', 'buros.nombre_buro')
                ->where('id_persona', session('id_persona'))
                ->where('id_credito', session('id_credito'))
                ->get();
            return view('oficial.reporte_buro.index')->with(compact('reporte_buro'));
        }

    }

    public function create()
    {
        if (session('id_persona') == null) {
            alert()->info('Info', 'Seleccione un socio')->showConfirmButton();
            return redirect('oficial/dashboard/');
        } else {
            $buros = Buro::All();
            $id_persona = session('id_persona'); //recuperando a id_persona de la variable de session
            $exist_reporte_buro = ReporteBuro::where('id_persona', $id_persona)->where('id_credito', session('id_credito'))->count();
            if ($exist_reporte_buro > 1) {
                alert()->info('Info', 'Ya registro sus datos de reporte buro.')->showConfirmButton();
                return redirect('oficial/reporte_buro/');
            } else {
                return view('oficial.reporte_buro.create')->with(compact('buros'));
            }
        }
    }

    public function store(ReporteBuroFormRequest $request)
    {
        $reporte = new ReporteBuro();
        $reporte->tiempo_maximo_mora = $request->input('tiempo_maximo_mora');
        $reporte->id_persona = session('id_persona');
        $reporte->id_credito = session('id_credito');
        $reporte->id_buro = $request->input('id_buro');
        $reporte->save(); //metodo se encarga de ejecutar un insert sobre la tabla
        flash()->addSuccess('El registro se ha creado correctamente');
        return redirect('oficial/reporte_buro/');
    }

    public function edit($id)
    {
        $reporte = ReporteBuro::find($id);
        $buros = Buro::All();
        return view('oficial.reporte_buro.edit')->with(compact('reporte', 'buros')); //formulario de registro
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'tiempo_maximo_mora' => 'required',
            'id_buro' => 'required|numeric',
        ]);
        // Buscar el modelo; si no existe, lanzar un 404
        $dep = ReporteBuro::findOrFail($id);

        // Actualizar usando los datos validados
        $dep->update($validatedData);
        flash()->addSuccess('Registro modificado', 'El registro ha sido modificado');
        return redirect('oficial/reporte_buro');
    }
}
