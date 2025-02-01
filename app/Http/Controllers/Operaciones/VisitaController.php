<?php

namespace sis5cs\Http\Controllers\Operaciones;

use Illuminate\Http\Request;
use sis5cs\Http\Controllers\Controller;
use sis5cs\Visita;

class VisitaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        $visitas = Visita::all();
        return view('operaciones.visitas.index')->with(compact('visitas'));
    }
    public function create()
    {
        $id_persona = session('id_persona');
        if ($id_persona == null) {
            alert()->info('Info', 'Seleccione un Socio')->showConfirmButton();
            return redirect('oficial/dashboard/');
        } else {
            $if_exist_c = Conyugue::where('id_persona', $id_persona)->count();
            if ($if_exist_c > 0) {
                alert()->info('Info', 'Ya registro los datos de conyugue.')->showConfirmButton();
                return redirect('oficial/conyugue/');
            } else {
                $profesiones = Profesion::All();
                $estados = EstadoCivil::All();
                $nacionalidades = Nacionalidad::All();
                $extensiones = Extension::All();
                return view('oficial.conyugue.create')->with(compact('profesiones', 'estados', 'nacionalidades', 'extensiones'));
            }
        }
    }
    public function store(ConyugueFormRequest $request)
    {
        $id_persona = session('id_persona');
        $persona = new Persona();
        $persona->ci = $request->input('ci');
        $persona->id_ext = $request->input('id_ext');
        $persona->nombre = $request->input('nombre');
        $persona->ap_paterno = $request->input('ap_paterno');
        $persona->ap_materno = $request->input('ap_materno');
        $persona->ap_casada = $request->input('ap_casada');
        $persona->fec_nac = $request->input('fec_nac');
        $persona->lugar_nac = $request->input('lugar_nac');
        $persona->genero = $request->input('genero');
        $persona->celular = $request->input('celular');
        $persona->dependientes = $request->input('dependientes');
        $persona->id_profesion = $request->input('id_profesion');
        $persona->id_estado_civil = $request->input('id_estado_civil');
        $persona->id_nacionalidad = $request->input('id_nacionalidad');
        $persona->save();       
        

        if ($persona->save() == true) {           
            $conyugue = new Conyugue();
            $conyugue->conyugue = $persona->id_persona;
            $conyugue->id_persona = $id_persona;
            $conyugue->save();
            $notification = 'Exelente conyugue creado correctamente';
            return redirect('oficial/conyugue/')->with(compact('notification'));
        }

    }

    public function edit($id)
    {        
        $visita = Visita::find($id);
        $visita->aprobado = 1;        
        $visita->update();     
        $notification = 'Exelente ha aprobado correctamente la visita';
        return redirect('operaciones/visitas')->with(compact('notification'));
    }
    public function denegar($id)
    {        
        $visita = Visita::find($id);
        $visita->aprobado = 2;        
        $visita->update();      
        $notification = 'Exelente ha Rechazado la visita';
        return redirect('operaciones/visitas')->with(compact('notification'));
    }
    
}
