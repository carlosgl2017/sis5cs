<?php

namespace sis5cs\Http\Controllers\Oficial;

use Illuminate\Http\Request;
use Session;
use sis5cs\ActividadEconomica;
use sis5cs\Http\Controllers\Controller;
use sis5cs\Http\Requests\ActividadEconomicaFormRequest;

class ActividadEconomicaController extends Controller
{
    public $id_persona;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if (session('id_persona') == null) {
            flash()->addWarning('Seleccione un socio.');
            return redirect('oficial/dashboard/');
        } else {
            $actividad = ActividadEconomica::
            where('id_persona', session('id_persona'))
                ->get();
            return view('oficial.actividad_economica.index')->with(compact('actividad'));
        }

    }

    public function create()
    {
        if (session('id_persona') == null) {
            flash()->addWarning('Seleccione un socio.');
            return redirect('oficial/dashboard/');
        } else {
            $if_exist = ActividadEconomica::where('id_persona', session('id_persona'))->count();
            if ($if_exist > 6) {
                flash()->addWarning('Ya registro los datos de Actividad Económica.');
                return redirect('oficial/actividad_economica/');
            } else {

                return view('oficial.actividad_economica.create');
            }

        }

    }

    public function store(ActividadEconomicaFormRequest $request)
    {
        $this->id_persona = session('id_persona');
        $actividad = new ActividadEconomica();
        $actividad->ciudad_ae = $request->input('ciudad_ae');
        $actividad->provincia_ae = $request->input('provincia_ae');
        $actividad->zona_ae = $request->input('zona_ae');
        $actividad->direccion_ae = $request->input('direccion_ae');
        $actividad->telefono_ae = $request->input('telefono_ae');
        $actividad->actividad_qrealiza = $request->input('actividad_qrealiza');
        $actividad->nit_ae = $request->input('nit_ae');
        $actividad->horario_trabajo_ae = $request->input('horario_trabajo_ae');
        $actividad->dias_trabajo_ae = $request->input('dias_trabajo_ae');
        $actividad->antiguedad_trabajo_ae = $request->input('antiguedad_trabajo_ae');
        $actividad->id_persona = $this->id_persona;
        $actividad->save(); //metodo se encarga de ejecutar un insert sobre la tabla
        flash()->addSuccess('Exelente los datos se han guardado correctamente');
        return redirect('oficial/actividad_economica');
    }

    public function edit($id)
    {
        $actividad = ActividadEconomica::find($id);
        return view('oficial.actividad_economica.edit')->with(compact('actividad')); //formulario de registro
    }

    public function update(ActividadEconomicaFormRequest $request, $id)
    {
        $this->id_persona = session('id_persona');
        $actividad = ActividadEconomica::find($id);
        $actividad->ciudad_ae = $request->input('ciudad_ae');
        $actividad->provincia_ae = $request->input('provincia_ae');
        $actividad->zona_ae = $request->input('zona_ae');
        $actividad->direccion_ae = $request->input('direccion_ae');
        $actividad->telefono_ae = $request->input('telefono_ae');
        $actividad->actividad_qrealiza = $request->input('actividad_qrealiza');
        $actividad->nit_ae = $request->input('nit_ae');
        $actividad->horario_trabajo_ae = $request->input('horario_trabajo_ae');
        $actividad->dias_trabajo_ae = $request->input('dias_trabajo_ae');
        $actividad->antiguedad_trabajo_ae = $request->input('antiguedad_trabajo_ae');
        $actividad->id_persona = $this->id_persona;
        $actividad->save(); //metodo se encarga de ejecutar un insert sobre la tabla
        flash()->addSuccess('Exelente sus datos se han modificado correctamente');
        return redirect('oficial/actividad_economica/');

    }

}
