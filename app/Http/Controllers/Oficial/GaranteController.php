<?php

namespace sis5cs\Http\Controllers\Oficial;

use sis5cs\Http\Controllers\Controller;
use Illuminate\Http\Request;
use sis5cs\Garante;
use sis5cs\Persona;
use sis5cs\Http\Requests\GaranteFormRequest;
use sis5cs\Http\Requests\PersonaFormRequest;
use DB;
use Session;
use sis5cs\EstadoCivil;
use sis5cs\Profesion;
use sis5cs\Nacionalidad;
use sis5cs\Extension;

class GaranteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $id_persona = session('id_persona');
        $id_credito = session('id_credito');
        $persona = DB::table('persona')
            ->join('profesion', 'persona.id_profesion', '=', 'profesion.id_profesion')
            ->join('nacionalidad', 'persona.id_nacionalidad', '=', 'nacionalidad.id_nacionalidad')
            ->join('estado_civil', 'persona.id_estado_civil', '=', 'estado_civil.id_estado_civil')
            ->join('garante', 'persona.id_persona', '=', 'garante.garante')
            ->join('extension_ci', 'persona.id_ext', '=', 'extension_ci.id_ext')
            ->select('persona.*', 'profesion.profesion', 'nacionalidad.nacionalidad', 'estado_civil.estado_civil', 'garante.ordinal_garante', 'extension_ci.extension')
            ->where('garante.id_persona', $id_persona)
            ->where('garante.id_credito', $id_credito)
            ->get();
        return view('oficial.garante.index')->with(compact('persona'));
    }

    public function create()
    {
        $id_persona = session('id_persona');
        if ($id_persona == null) {
            flash()->addWarning('Seleccione un crédito.');
            return redirect('oficial/dashboard/');
        } else {
            $if_exist_g = Garante::where('id_persona', $id_persona)->count();
            if ($if_exist_g > 50) {
                alert()->info('Info', 'Ya registro los datos de garante.')->showConfirmButton();
                return redirect('oficial/garante/');
            } else {
                $profesiones = Profesion::All();
                $estados = EstadoCivil::All();
                $nacionalidades = Nacionalidad::All();
                $extensiones = Extension::All();
                return view('oficial.garante.create')->with(compact('profesiones', 'estados', 'nacionalidades', 'extensiones'));
            }
        }
    }

    public function store(GaranteFormRequest $request)
    {
        $persona = new Persona();
        $persona->ci = $request->input('ci');
        $persona->id_ext = $request->input('id_ext');
        $persona->num_socio = $request->input('num_socio');
        $persona->nombre = $request->input('nombre');
        $persona->ap_paterno = $request->input('ap_paterno');
        $persona->ap_materno = $request->input('ap_materno');
        $persona->ap_casada = $request->input('ap_casada');
        $persona->fec_nac = $request->input('fec_nac');
        $persona->lugar_nac = $request->input('lugar_nac');
        $persona->departamento_nac = $request->input('departamento_nac');
        $persona->ciudad_nac = $request->input('ciudad_nac');
        $persona->provincia_nac = $request->input('provincia_nac');
        $persona->genero = $request->input('genero');
        $persona->celular = $request->input('celular');
        $persona->dependientes = $request->input('dependientes');
        $persona->id_profesion = $request->input('id_profesion');
        $persona->id_estado_civil = $request->input('id_estado_civil');
        $persona->id_nacionalidad = $request->input('id_nacionalidad');
        $persona->save();

        if ($persona->save() === true) {
            $garante = new Garante();
            $garante->garante = $persona->id_persona;
            $garante->id_persona = session('id_persona');
            $garante->id_credito = session('id_credito');
            $garante->ordinal_garante = $request->input('ordinal_garante');
            $garante->save();
            $notification = 'Exelente garante creado correctamente';
            return redirect('oficial/garante/')->with(compact('notification'));
        }

    }

    public function edit($id)
    {
        $persona = Persona::find($id);
        $profesion = Profesion::all();
        $nacionalidad = Nacionalidad::all();
        $estados = EstadoCivil::all();
        $extensiones = Extension::all();
        $garante = Garante::where('garante', $id)->get();
        return view('oficial.garante.edit')->with(compact('persona', 'profesion', 'nacionalidad', 'estados', 'extensiones', 'garante')); //formulario de registro
    }

    public function update(Request $request, $id)
    {
        // registrar el nuevo cliente
        // dd($request->all()); método dd muestra el contenido del array
        $this->validate($request, [
            'ci' => 'string|max:20',
            'nombre' => 'string|max:50',
            'ap_paterno' => 'string|max:50',
            'ap_materno' => 'string|max:50',
            'celular' => 'numeric',
            'fec_nac' => 'date',
            'ordinal_garante' => 'numeric|max:4'
        ]);
        $persona = Persona::find($id);
        $persona->ci = $request->input('ci');
        $persona->id_ext = $request->input('id_ext');
        $persona->num_socio = $request->input('num_socio');
        $persona->nombre = $request->input('nombre');
        $persona->ap_paterno = $request->input('ap_paterno');
        $persona->ap_materno = $request->input('ap_materno');
        $persona->ap_casada = $request->input('ap_casada');
        $persona->fec_nac = $request->input('fec_nac');
        $persona->lugar_nac = $request->input('lugar_nac');
        $persona->departamento_nac = $request->input('departamento_nac');
        $persona->ciudad_nac = $request->input('ciudad_nac');
        $persona->provincia_nac = $request->input('provincia_nac');
        $persona->genero = $request->input('genero');
        $persona->celular = $request->input('celular');
        $persona->dependientes = $request->input('dependientes');
        $persona->id_profesion = $request->input('id_profesion');
        $persona->id_estado_civil = $request->input('id_estado_civil');
        $persona->id_nacionalidad = $request->input('id_nacionalidad');
        $persona->save(); //metodo se encarga de ejecutar un insert sobre la tabla

        $id_garante = Garante::where('garante', $id)->firstOrFail()->id_garante;
        $ordinal = Garante::find($id_garante);
        $ordinal->ordinal_garante = $request->input('ordinal_garante');
        $ordinal->save();
        $notification = 'Exelente sus datos  se modificaron correctamente';
        return redirect('oficial/garante')->with(compact('notification'));
    }

    public function vincularcreate()
    {

        $id_persona = session('id_persona');
        $id_credito = session('id_credito');
        if ($id_persona == null) {
            flash()->addWarning('Seleccione un Socio');
            return redirect('oficial/dashboard/');
        }
        if ($id_credito == null) {
            flash()->addWarning('Seleccione un Crédito');
            return redirect('oficial/garante/');
        } else {
            $personas = Persona::All();
            return view('oficial.garante.vincularcreate')->with(compact('personas'));
        }
    }

    public function vincularstore(Request $request)
    {

            $garante = new Garante();
            $garante->garante = $request->input('id_persona_garante');
            $garante->id_credito = $request->input('id_credito');
            $garante->id_persona = $request->input('id_persona');
            $garante->ordinal_garante = 1;
            $garante->save();
            flash()->addSuccess('Registro exitoso.');
            return redirect('oficial/garante/');

    }
}


