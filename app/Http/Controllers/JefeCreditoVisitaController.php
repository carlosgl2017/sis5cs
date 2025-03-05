<?php

namespace sis5cs\Http\Controllers\JefeCredito;

use Illuminate\Http\Request;
use sis5cs\Http\Controllers\Controller;
use sis5cs\Visita;
use DB;
use PDF;
use DateTime;
use Carbon\Carbon;
use sis5cs\ControlDistanciaOficial;
use sis5cs\ControlOficial;

class VisitaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        $visitas = DB::table('visita')
        ->join('users', 'users.id_users', '=', 'visita.id_users')
        ->select('users.name', 'visita.*')
        ->get();
        return view('jefecredito.visitas.index')->with(compact('visitas'));
    }
    public function create()
    {
        $id_persona = session('id_persona');
        if ($id_persona == null) {
            flash()->addWarning('Seleccione un crédito.');
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
        $control= new ControlOficial();
        $control->id_visita = $id;
        $control->save();   
        $notification = 'Exelente ha aprobado correctamente la visita';
        return redirect('jefecredito/visitas')->with(compact('notification'));
    }
    public function denegar($id)
    {        
        $visita = Visita::find($id);
        $visita->aprobado = 2;        
        $visita->update();  
        $control = ControlOficial::find($id);
        if($control == true){
          $control ->delete(); 
        }
           
        $notification = 'Exelente ha Rechazado la visita';
        return redirect('jefecredito/visitas')->with(compact('notification'));
    }
    public function listar()
    {
        $visitas = DB::table('visita')
        ->join('users', 'users.id_users', '=', 'visita.id_users')
        ->select('users.name', 'visita.id_visita','visita.estado')
        ->get();
        return view('jefecredito.ubicacion.index', compact('visitas'));
    }
    public function ubicacion($id)
    {
        $visita = DB::table('visita')
        ->join('control_oficial', 'control_oficial.id_visita', '=', 'visita.id_visita')
        ->join('control_distancia_oficial', 'control_distancia_oficial.id_control', '=', 'control_oficial.id_control')
        ->select('control_distancia_oficial.latitud','control_distancia_oficial.longitud')
        ->where('visita.id_visita', $id)
        ->orderby('control_distancia_oficial.created_at','DESC')
        //->take(1)
        ->get(); 
        ///return $visita;
        $hptam= sizeof($visita); 
        return view('jefecredito.ubicacion.ubicacion', compact('visita', 'hptam','id'));
    }
    
    public function listaoficial()
    {
        
        $oficial = DB::table('users')
        ->select('name','id_users')
        ->where('id_rol', 3)
        ->get(); 
        return view('jefecredito.ubicacion.listaoficial',compact('oficial'));
    }
    public function reporteubicacion($id)
    {
        $visita = DB::table('visita')
        ->select('fecha_visita', DB::raw('count(*) as total'))
        ->where('visita.id_users', $id)
        ->where('visita.aprobado', 1)
        ->where('visita.estado', true)
        ->groupBy('fecha_visita') 
        ->get(); 
       
        $iduser=$id;
        return view('jefecredito.ubicacion.reporteubicacion',compact('visita','iduser'));
    }
    public function report($id, $id2, $iduser)
    {
        
        $idvisitas = DB::table('visita') //esta guarda las id de visitas
        ->join('credito', 'credito.id_credito', '=', 'visita.id_credito')
        ->join('persona', 'persona.id_persona', '=', 'credito.id_persona')
        ->select('visita.id_visita','persona.nombre','persona.ap_paterno','persona.ap_materno','credito.id_credito')
        ->where('visita.id_users', $iduser)
        ->where('fecha_visita',$id)
        ->where('visita.estado', true)
        ->where('visita.aprobado', 1)
        ->orderBy('visita.id_visita')
        ->get();
       

        $colores=['','#c73730','#563d7c','#c7d419','#1f30c4','#24a634','#0a0a0a'];
        $cantvisita= $id2;
        $id_credito;
        $id_visita;
        $fecha=$id; //fecha de las ubicaciones
        foreach($idvisitas as $vis){
        $fotoubicacion = DB::table('seguimiento_fotografico') //esto saca la longitud y latitud de la carpeta de fotos
        ->join('visita', 'visita.id_visita', '=', 'seguimiento_fotografico.id_visita')
        ->select('seguimiento_fotografico.longitud','seguimiento_fotografico.latitud')
        ->where('visita.id_users', $iduser)
        ->where('seguimiento_fotografico.id_visita', $vis->id_visita)
        ->whereDate('seguimiento_fotografico.created_at', $id)
        ->get();
    }
        $idcontrol =collect() ; 
        $latlong27=collect() ; 
        foreach($idvisitas as $vis){
        $control = DB::table('control_oficial') //id tiene la fecha de los grupos de visitas
        ->select('id_control')
        ->where('id_visita', $vis->id_visita)
        ->whereDate('fecha_inicio', $id)
        ->whereDate('fecha_fin', $id)
        ->get(); 
        $idcontrol->push($control); 
        }
        ///return $idcontrol;
                            //control tiene el id de las visitas
        $tamcontrol= sizeof($idcontrol);
         //tiene el numero de visitas que tiene esta fecha 
        $ubicacionvisita =collect() ;  
        $ubicacionvisitatodo =collect() ; 
        //return $idcontrol[0];
        for($i =0;$i<$tamcontrol;$i++){
            foreach($idcontrol[$i][0] as $con)
            {
                  $inicio= DB::table('control_distancia_oficial') //esto obtiene el primer registro del dia
                  //->select('longitud','latitud')
                  ->where('id_control', $con)
                  ->orderby('created_at')
                  ->take(1)
                  ->get();
                 
                  $fin= DB::table('control_distancia_oficial')//este obtiene el ultimo valor registro del dia
                  //->select('longitud','latitud')
                  ->where('id_control',$con)
                  ->orderby('created_at','DESC')
                  ->take(1)
                  ->get();
                  $todo = DB::table('control_distancia_oficial')
                  ->where('id_control',$con)
                  ->orderby('id_control_distancia')
                  ->get();
                 
                  $ubicacionvisita->push($inicio); 
                  $ubicacionvisita->push($fin); 
                  $ubicacionvisitatodo->push($todo);
                  
                  //crear collection para colocar la long y lat
                  //crear otra collection para colocar el inicio y fin de cada visita o de la long y lat probar eso
                 
            }
            ////return $todo;
            //return $ubicacionvisitatodo;
            $count=1;  ////count cuenta el numero de datos que hay dentro la collection
            $cantdatos =0; //este cuenta cuantois datos hay dentro de la collection
            $multiplicar =1; ///este numero es que se multiplicara de tanto en tanto
           //return $tamubicacionvisitatodo; 
           //// return $count;
        ////return $ubicacionvisitatodo[0][1];
           
        }
        $tamubicacionvisitatodo= sizeof($ubicacionvisitatodo);//tamanio del collect de todas las long y lat
        $tamubicacionvisita= sizeof($ubicacionvisita);//tamanio del collect del inicio y fin de long y lat

        $idverificado = array();
        
          for(  $k = 0 ; $k < $tamubicacionvisitatodo ; $k++){
                foreach ($ubicacionvisitatodo[$k] as $ub){
                    $idcontroloficial[] =  (array) $ub->id_control_distancia ;
                }
            
            }
            $cantidcontrol= sizeof($idcontroloficial);
            $cantidverificado;
            
             //return $cantidcontrol;
        
        ////return $idcontroloficial;
        if($cantidcontrol <=27){
            //return $cantidcontrol;
            $cantidverificado=$tamubicacionvisitatodo;
            $latlong27=$ubicacionvisitatodo;
            return view('jefecredito.ubicacion.reporte',compact('idvisitas','ubicacionvisita','tamubicacionvisita','cantvisita','colores','fotoubicacion','fecha','iduser','ubicacionvisitatodo','tamubicacionvisitatodo','latlong27','cantidverificado'));
        

        }
        else{
            if($cantidcontrol > 27){
                for($i=1;$i<10;$i++){
                    $numero =25*$i;  ///este es numero mayor que si sirve  y donde $i es el numero por el cual se hara el salto de tanto en tanto
                    if($cantidcontrol < $numero ){
                           $mul=$i; 
                           for( $k =0 ;$k<$cantidcontrol;$k++){
                            if($k == $cantidcontrol-1){
                                array_push($idverificado, $idcontroloficial[$k]);
                            }
                            $multiplicar =$multiplicar*$mul;
                            if($k% $mul == 0){
                                array_push($idverificado, $idcontroloficial[$k]);
                                
                            }
                            
                        }  $i=10;
                    } 
                }
                //return $idverificado;
                $cantidverificado= sizeof($idverificado);
                for( $k =0 ;$k<$cantidverificado;$k++){
                $controloficial2 = DB::table('control_distancia_oficial')
                ->where('id_control_distancia',$idverificado[$k])
                ->orderby('id_control_distancia')
                ->get();
                $latlong27->push($controloficial2);
                }
                //return $latlong27;
                /////////////$ubicacionvisitatodo = $latlong27;
                ////return $ubicacionvisitatodo;
                return view('jefecredito.ubicacion.reporte',compact('idvisitas','ubicacionvisita','tamubicacionvisita','cantvisita','colores','fotoubicacion','fecha','iduser','ubicacionvisitatodo','tamubicacionvisitatodo','latlong27','cantidverificado'));
        
                
            }
        }
        
        
        
    }
    public function imprimir($fecha, $iduser,$idvis)
    {
       
       
           $calculo= DB::table('control_oficial')
                  ->select('fecha_inicio','fecha_fin')
                  ->where('id_visita',$idvis)
                  ->whereDate('fecha_inicio',$fecha)
                  ->whereDate('fecha_fin',$fecha)
                  ->get();
                  

            $user= DB::table('users') 
                  ->select('name')
                  ->where('id_users',$iduser)
                  ->first();
            $name=$user->name; 
            $now = Carbon::now();      
            $tiempototal =collect() ;
            $tiempoinifin =collect();
            $tiem=collect() ;
            foreach($calculo as $cal){
               //$fe =Carbon::parse($fechainicio)->format('H:i:s'); //lo mismo cambia de fecha solo a hora
               $fechainicio=$cal->fecha_inicio;
               $fechafin=$cal->fecha_fin;
              
               $fecha1 = new DateTime(date($fechainicio));
               $fecha2 = new DateTime(date($fechafin));
               $fechadif = $fecha1->diff($fecha2);
               
               $fechahorainicio = substr($fechainicio, 11);
               $fechahorafin = substr($fechafin, 11);
               
               $fechadif->format("h:i:s");
        
               $tiempototal->push($fechadif );
               
               $tiempoinifin ->push($fechahorainicio);
               $tiempoinifin ->push($fechahorafin);

         }
         $horas = array();
         $minutos = array();
         $tamtiempoinifin= sizeof($tiempoinifin);
         $tamtiempototal= sizeof($tiempototal);
                foreach($tiempototal as $object)
                    {
                        $horas[] =  (array) $object->h ;
                        $minutos[] =  (array) $object->i;
                        $segundos[] =  (array) $object->s;
                   }
            
               $datos = DB::table('visita')
               ->join('credito', 'credito.id_credito', '=', 'visita.id_credito')
               ->join('persona', 'persona.id_persona', '=', 'credito.id_persona')
               ->select('visita.id_visita','persona.nombre','persona.ap_paterno','persona.ap_materno','visita.id_credito','visita.longitud','visita.latitud','visita.direccion','visita.ciudad')
               //->where('visita.fecha_visita', $fecha)
               ->where('visita.id_visita', $idvis)
               ->where('visita.id_users',$iduser)
               ->where('visita.aprobado', 1)
               ->where('visita.estado', true)
               ->get(); 
               foreach($datos as $object)
                    {
                        $nombre[] =  (array) $object->nombre ;
                        $ap_paterno[] =  (array) $object->ap_paterno;
                        $ap_materno[] =  (array) $object->ap_materno;
                        $id_credito[] =  (array) $object->id_credito;
                        $direccion[] =  (array) $object->direccion;
                        $ciudad[] =  (array) $object->ciudad;
                        $idvisita[] =  (array) $object->id_visita;
                   }
                   $tamidvisita= sizeof($idvisita);
                   $datosvisita =collect();
                   for($i=0;$i<$tamidvisita; $i++){
                   $visitatodo = DB::table('visita')
                  ->join('seguimiento_fotografico', 'seguimiento_fotografico.id_visita', '=', 'visita.id_visita')
                  ->join('foto', 'foto.id_seguimiento_foto', '=', 'seguimiento_fotografico.id_seguimiento_foto')
                  ->select('visita.id_visita','seguimiento_fotografico.descripcion','seguimiento_fotografico.latitud','seguimiento_fotografico.longitud','foto.id_foto','foto.archivo','foto.created_at')
                  ->where('visita.id_visita', $idvisita[$i])
                  //->orderby('seguimiento_fotografico.id_seguimiento_foto','DESC')
                  ->take(2)
                  //->where('visita.id_users',$iduser)
                  ->get(); 
                  $datosvisita->push($visitatodo );
                   }
              
            return view('jefecredito.ubicacion.imprimir',compact('idvis','datos','tiempototal','tamtiempototal','fecha','name','now','tiempoinifin','horas','minutos','segundos','nombre','ap_paterno','ap_materno','id_credito','ciudad','direccion','datosvisita'));
        
    }
    public function imprimir2($fecha, $iduser,$idvis)
    {
        
        $datos = DB::table('visita')
        ->join('credito', 'credito.id_credito', '=', 'visita.id_credito')
        ->join('persona', 'persona.id_persona', '=', 'credito.id_persona')
        ->join('estado_civil', 'estado_civil.id_estado_civil', '=', 'persona.id_estado_civil')
        ->join('tipo_credito', 'tipo_credito.id_tcredito', '=', 'credito.id_tcredito')
        ->select('visita.id_visita','persona.nombre','persona.ap_paterno','persona.ap_materno','persona.celular','persona.ci','visita.*','estado_civil.estado_civil','credito.id_credito','tipo_credito.tipo_credito')
        //->where('visita.fecha_visita', $fecha)
        ->where('visita.id_visita',$idvis)
        ->where('visita.id_users',$iduser)
        ->where('visita.aprobado', 1)
        ->where('visita.estado', true)
        ->get(); 
        $user= DB::table('users') 
                  ->select('name')
                  ->where('id_users',$iduser)
                  ->first();
                  $name=$user->name;
        $now = Carbon::now();
        $pdf = PDF::loadView('jefecredito.ubicacion.imprimir2',compact('datos','fecha','now','name'));
        return $pdf->stream();
         return $pdf->download('invoice.pdf');
    }
    
}
