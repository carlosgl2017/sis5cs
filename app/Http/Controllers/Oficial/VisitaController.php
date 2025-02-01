<?php

namespace sis5cs\Http\Controllers\Oficial;

use Illuminate\Http\Request;
use sis5cs\Http\Controllers\Controller;
use sis5cs\Visita;
use Session;
use Carbon\Carbon;
use Auth;
use DB;

class VisitaController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        $user = Auth::user()->id_users;
        if (session('id_credito') == null) {
            alert()->info('Info', 'Seleccione un Cr�dito')->showConfirmButton();
            return redirect('oficial/dashboard/');
        } else {
            
            $visitas = DB::table('visita')
            ->join('users', 'users.id_users', '=', 'visita.id_users')
            ->select('visita.*')
            ->where('users.id_users',$user)
            ->get();
            return view('oficial.visitas.index')->with(compact('visitas'));
        }
    }
    public function create()
    {
        if (session('id_credito') == null) {
            alert()->info('Info', 'Seleccione un crédito')->showConfirmButton();
            return redirect('oficial/dashboard/');
        } else {
            return view('oficial.visitas.create');
        }
    }
    public function visita_realizada($id)
    {
        $visita = Visita::find($id);
        if($visita->aprobado==1)
        {
            $visita = Visita::find($id);
            $visita->estado = true;        
            $visita->update(); //metodo se encarga de ejecutar un insert sobre la tabla        
            $notification = 'Exelente ha completado la visita de seguimiento';
            return redirect('oficial/visitas')->with(compact('notification'));
        }elseif($visita->aprobado==0)
        {
            $notification = 'La visita está pendiente de aprobación';
            return redirect('oficial/visitas')->with(compact('notification'));
        }elseif($visita->aprobado==2)
        {
            $notification = 'La visita ha sido rechazada';
            return redirect('oficial/visitas')->with(compact('notification'));
        }
        
    }
    public function store(Request $request)
    {
    
        if (session('id_credito') == null) {
            alert()->info('Info', 'Seleccione un Crédito')->showConfirmButton();
            return redirect('oficial/dashboard/');
        } else {
           
        $now = Carbon::now();
        $this->validate($request, [
            'fecha_visita' => 'date|required',
            'hora_visita' => 'required',
            'duracion_minutos' => 'numeric|required',
            'latitud' => 'numeric|required',
            'longitud' => 'numeric|required',
            'direccion' => 'string|required',
            'departamento' => 'string|required',
            'ciudad' => 'string|required',
            'provincia' => 'string|required',
            'localidad' => 'string|nullable'
        ]);

        $visita = new Visita();
        $visita->fecha_visita = $request->input('fecha_visita');
        $visita->hora_visita = $request->input('hora_visita');
        $visita->duracion_minutos = $request->input('duracion_minutos');
        $visita->fecha_programacion =$now;
        $visita->latitud = $request->input('latitud');
        $visita->longitud = $request->input('longitud');
        $visita->direccion = $request->input('direccion');
        $visita->departamento = $request->input('departamento');
        $visita->ciudad = $request->input('ciudad');
        $visita->provincia = $request->input('provincia');
        $visita->localidad = $request->input('localidad');
        $visita->id_credito = session('id_credito');
        $visita->id_users = Auth::user()->id_users;
        $visita->save(); //metodo se encarga de ejecutar un insert sobre la tabla
        $notification = 'Los datos se guardaron correctamente';
        return redirect('/oficial/visitas/')->with(compact('notification'));
        }

    }

}
