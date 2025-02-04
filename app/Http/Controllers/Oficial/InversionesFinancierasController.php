<?php

namespace sis5cs\Http\Controllers\Oficial;

use sis5cs\Http\Controllers\Controller;
use Illuminate\Http\Request;

use sis5cs\Http\Requests\InversionesFinancierasFormRequest;
use sis5cs\InversionesFinancieras;
use sis5cs\ReporteBuro;
use sis5cs\TipoVivienda;
use sis5cs\Persona;
use Session;
use DB;
use Fpdf;
use Auth;
use Alert;

class InversionesFinancierasController extends Controller
{
    public $id_persona;

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        //$this->id_persona=session('id_persona');
        if (session('id_persona') == null || session('id_credito') == null) {
            alert()->info('Info', 'Seleccione un Socio o Crédito')->showConfirmButton();
            return redirect('oficial/dashboard/');
        } else {
            $inversiones = InversionesFinancieras::where('id_persona', session('id_persona'))->where('id_credito', session('id_credito'))->get();
            return view('oficial.inversiones_financieras.index')->with(compact('inversiones'));
        }

    }

    public function create()
    {
        if (session('id_persona') == null || session('id_credito') == null) {
            alert()->info('Info', 'Seleccione un Socio o credito')->showConfirmButton();
            return redirect('oficial/dashboard/');
        } else {

            $if_exist = InversionesFinancieras::where('id_persona', session('id_persona'))->where('id_credito', session('id_credito'))->count();
            if ($if_exist > 100) {
                alert()->info('Info', 'Ya registro los datos de inversiones financieras')->showConfirmButton();
                return redirect('oficial/inversiones_financieras/');
            } else {
                return view('oficial.inversiones_financieras.create');
            }
        }
    }

    public function store(InversionesFinancierasFormRequest $request)
    {
        // Crear el registro directamente usando el método fill
        $inversiones = new InversionesFinancieras();
        $inversiones->fill($request->validated()); // Usar los datos ya validados del FormRequest
        $inversiones->save();
        session()->flash('success', '¡Excelente! Los datos se han guardado correctamente.');
        return redirect('oficial/inversiones_financieras');
    }

    public function edit($id)
    {
        $inversiones = InversionesFinancieras::find($id);
        return view('oficial.inversiones_financieras.edit')->with(compact('inversiones')); //formulario de registro
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'cantidad' => 'numeric',
            'porcentaje_patrimonio_empre' => 'numeric',
            'nit' => 'numeric',
            'nombre_empresa' => 'string',
            'valor_nominal' => 'numeric',
            'valor_mercado' => 'numeric',
            'detalle' => 'string',
        ]);
        // Buscar el modelo; si no existe, lanzar un 404
        $dep = InversionesFinancieras::findOrFail($id);
        // Actualizar usando los datos validados
        $dep->update($validatedData);
        flash()->addSuccess('Registro modificado', 'El registro ha sido modificado');
        return redirect('oficial/inversiones_financieras');
    }
}
