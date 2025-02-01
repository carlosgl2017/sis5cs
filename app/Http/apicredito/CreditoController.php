<?php
namespace sis5cs\Http\Controllers\apicredito;

use App\Http\Requests\RegisterAuthRequest;
use Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\http\Response;
use Illuminate\Http\Request;
use sis5cs\Http\Controllers\Controller;
use sis5cs\Http\Requests\UserFormRequest;
use sis5cs\Rol;
use Tymon\JWTAuth\Exceptions\JWTException;
use JWTAuth; 
use File;
use DB;
use sis5cs\Credito;
use sis5cs\Persona;
use sis5cs\Foto;  
use sis5cs\SeguimientoFoto; 
use sis5cs\ControlOficial; 
use sis5cs\ControlDistanciaOficial; 
use sis5cs\Visita; 
use Validator;
use Image;
use sis5cs\Http\Requests\FotoFormRequest;
use Symfony\Component\HttpFoundation\File\UploadedFile;


class CreditoController extends Controller
{
    public function index() {
        //$input = $request->only('id_credito', 'id_persona');
        $credito = Credito::select("credito.*")->get()->toArray();
        return response()->json($credito);

        
        
    }
        

    public function show($id)
    {  
        
        $credito = Credito::select("credito.*")
        ->where("credito.id_credito", $id)
        ->first();
        return response()->json([
              "ok" => true,
              "data"=>$credito,
        ]);
    }
    public function busqueda(Request $request)
    {
        $nombre= $request->input('nombre');
        $apellido_pa= $request->input('ap_paterno');
        $apellido_ma= $request->input('ap_materno');
        $ci= $request->input('ci');
         
        $persona = DB::table('persona')
        ->where('ap_materno', null)
        ->update(['ap_materno'=> ""]);
    
        if($nombre != null && $apellido_pa == null && $apellido_ma ==null && $ci==null){
        $credito = DB::table('credito')
        ->join('persona', 'persona.id_persona', '=', 'credito.id_persona')
        //->join('visita', 'visita.id_credito', '=', 'credito.id_credito')
        ->select('credito.id_credito','persona.id_persona','persona.nombre','persona.ap_paterno','persona.ap_materno','credito.fecha_solicitud')      
        ->where("persona.nombre","ilike","%".$nombre."%")  
        //->where("persona.nombre",$nombre) 
        //->where('persona.ap_materno', null)
        //->update(['persona.ap_materno'=> ""])
        //->where("persona.ap_paterno",$apellido_pa)   
        //->where("persona.ap_materno",$apellido_ma)
        //->orwhere("persona.ci",$ci)
        ->get();}
        
        if($apellido_pa != null  && $nombre == null  && $apellido_ma ==null && $ci==null){
            $credito = DB::table('credito')
            ->join('persona', 'persona.id_persona', '=', 'credito.id_persona')
            ->select('credito.id_credito','persona.id_persona','persona.nombre','persona.ap_paterno','persona.ap_materno','credito.fecha_solicitud')      
            ->where("persona.ap_paterno","ilike",$apellido_pa) 
            ->get();}
            if( $apellido_ma !=null && $nombre == null && $apellido_pa == null  && $ci == null){
                $credito = DB::table('credito')
                ->join('persona', 'persona.id_persona', '=', 'credito.id_persona')
                ->select('credito.id_credito','persona.id_persona','persona.nombre','persona.ap_paterno','persona.ap_materno','credito.fecha_solicitud')      
                ->where("persona.ap_materno","ilike",$apellido_ma) 
                ->get();}
                if($nombre == null && $apellido_pa == null && $apellido_ma ==null && $ci !=null){
                    $credito = DB::table('credito')
                    ->join('persona', 'persona.id_persona', '=', 'credito.id_persona')
                    ->select('credito.id_credito','persona.id_persona','persona.nombre','persona.ap_paterno','persona.ap_materno','credito.fecha_solicitud')      
                    ->where("persona.ci",$ci) 
                    ->get();}
                    if($nombre != null && $apellido_pa != null && $apellido_ma !=null && $ci !=null){
                        $credito = DB::table('credito')
                        ->join('persona', 'persona.id_persona', '=', 'credito.id_persona')
                        ->select('credito.id_credito','persona.id_persona','persona.nombre','persona.ap_paterno','persona.ap_materno','credito.fecha_solicitud')      
                        ->where("persona.nombre","ilike",$nombre)
                        ->where("persona.ap_paterno","ilike",$apellido_pa)
                        ->where("persona.ap_materno","ilike",$apellido_ma)
                        ->where("persona.ci",$ci) 
                        ->get();}
        return response()->json([
            "ok" => true,
            "data"=>$credito,
      ]);
    }
    

    public function store(Request $request)
    {    
        $path = public_path() . '/images/fotos/';
        $imagenOriginal = $request->file('archivo');
        $imagen = Image::make($imagenOriginal);
        $temp_name = uniqid() . '.' . $imagenOriginal->getClientOriginalExtension();
        $imagen->resize(800, 600);
        $imagen->save($path . $temp_name, 100);
        //variable temporal
        $foto = new Foto();
        $foto->archivo = $temp_name;
        $foto->detalle =$request ->input('detalle');
        $foto->id_seguimiento_foto = $request->input('id_seguimiento_foto');
        $foto->save();
    
        
    }
    public function store2(FotoFormRequest $request)
    {   
         
        if(empty($id)== false){
            $longitud=null;
            $latitud=null;
         }
       
        $fot= $request-> file('fotografia'); 
        $urlimage=[];
        foreach($fot as $fo){
        $path = public_path() . '/images/fotos/'; 
        $imagen = Image::make($fo);   
        $temp_name = uniqid() . '.' . $fo->getClientOriginalExtension();
        $imagen->resize(800, 600);
        $imagen->save($path . $temp_name, 100);
        $urlimage[]=$temp_name;
        $tam= sizeof($urlimage); //tama;o del array
         }
         $fotoseguimiento = new SeguimientoFoto();
         $fotoseguimiento->descripcion= $request-> input('titulo');
         //$fotoseguimiento->id_credito =session('id_credito');
         $fotoseguimiento->id_credito =$request->input('id_credito');
         //$fotoseguimiento->longitud = $request-> input('longitud');
         //$fotoseguimiento->latitud = $request-> input('latitud');
         $fotoseguimiento->id_credito =('id_visita');
         $fotoseguimiento->save();
         for($i =0;$i<$tam;$i++){
         $foto = new Foto();
         $foto->archivo = $urlimage[$i];
         $foto->detalle =$request ->input('detalle');
         $foto->id_seguimiento_foto=$fotoseguimiento->id_seguimiento_foto;
         $foto->save();
        
        }
             
    }
  
    public function listuser(Request $request)
    {  
        
        $id_persona= $request->input('id_persona');  
        $persona = DB::table('credito')
        ->join('persona', 'persona.id_persona', '=', 'credito.id_persona')
        ->select('persona.nombre','persona.ap_paterno','persona.ap_materno','credito.id_credito','credito.fecha_solicitud')
        ->where('credito.id_persona', $id_persona)
        ->get();
        //return $persona;
        return response()->json([
              "ok" => true,
              "data"=>$persona,
        ]);
    }
    public function listarcarpetauser(Request $request)
   {
           
    $id_credito= $request->input('id_credito');  
    $listaseguimiento = DB::table('seguimiento_fotografico')
    //->join('persona', 'persona.id_persona', '=', 'credito.id_persona')
    ->select('seguimiento_fotografico.id_seguimiento_foto','seguimiento_fotografico.descripcion','seguimiento_fotografico.created_at')
    ->where('seguimiento_fotografico.id_credito', $id_credito)
    ->get();
    //return $persona;
    return response()->json([
          "ok" => true,
          "data"=>$listaseguimiento,
    ]);
   }
   public function nuevacarpeta(Request $request)
   {
         
    $fotoseguimiento = new SeguimientoFoto();
    $fotoseguimiento->descripcion= $request-> input('descripcion');
    $fotoseguimiento->id_credito =$request-> input('id_credito');
    $fotoseguimiento->id_visita =$request-> input('id_visita');
    $fotoseguimiento->longitud = $request->input('longitud');
    $fotoseguimiento->latitud = $request->input('latitud');
    $fotoseguimiento->save();
   }

   public function visita(Request $request)
   {
      
       //return "HOLOS";
       $id_users = $request->input('id_users');
       
       $visita = DB::table('visita')
       ->join('credito', 'credito.id_credito', '=', 'visita.id_credito')
       ->join('persona', 'persona.id_persona', '=', 'credito.id_persona')
       ->select('visita.*','persona.nombre','persona.ap_paterno','persona.ap_materno')
       ->where('visita.id_users', $id_users)
       ->where('visita.aprobado', 1)
       ->where('visita.estado', false)
       ->get();
       return response()->json([
        "ok" => true,
        "data"=>$visita,
       ]);
   }
   public function control(Request $request)
   {
       //ESTO FUNCIONA!!! siempre y cuando ya este creado el control
       $estado = $request->input('estado');
       $id_visita=$request->input('id_visita');
       $inicio=$request->input('numero'); //es el numero que dice si comienza o para el envio de ubicacion
       $fecha_inicio=$request->input('fecha_inicio');  //fecha inicio vacio de la app
       $fecha_fin=$request->input('fecha_fin');       //fecha fin vacio de la app
       $controls = DB::table('control_oficial')
       ->select('id_visita','fecha_inicio','fecha_fin','id_control') //esto es dde la tabla
       ->where('control_oficial.id_visita', $id_visita)
       ->get();
       
       foreach($controls as $con)
       {
           $fecha_inicio_tab=$con->fecha_inicio;  //esto cpmprueba si la fecha inicio es null o nel
           $fecha_fin_tab=$con->fecha_fin;       //comprueba si al fecha fin es null o no
           $id_control=$con->id_control;       
           //$id_visita=$con->id_visita;
       }
       
       if($controls == true && $inicio == 0 && $fecha_inicio_tab == null && $fecha_fin_tab == null){
        $controldistancia = new ControlDistanciaOficial();
        $controldistancia->latitud =$request->input('latitud');
        $controldistancia->longitud =$request->input('longitud');
        $controldistancia->id_control =$id_control;
        $controldistancia->save();
          $contr = DB::table('control_oficial')
          ->where('control_oficial.id_visita', $id_visita)
          ->update(['fecha_inicio'=> $fecha_inicio])
          
          ->get();
          
       // return "Inicio";

       }
       elseif($controls == true && $inicio == 0 && $fecha_inicio_tab != null && $fecha_fin_tab == null){
        $controldistancia = new ControlDistanciaOficial();
        $controldistancia->latitud =$request->input('latitud');
        $controldistancia->longitud =$request->input('longitud');
        $controldistancia->id_control =$id_control;
        $controldistancia->save();
        //return "Continuacion";
       }
       elseif($controls == true && $inicio == 1 && $fecha_inicio_tab != null && $fecha_fin_tab == null ){
        $controldistancia = new ControlDistanciaOficial();
        $controldistancia->latitud =$request->input('latitud');
        $controldistancia->longitud =$request->input('longitud');
        $controldistancia->id_control =$id_control;
        $controldistancia->save();
        $visita = Visita::find($id_visita);
        $visita->update(['estado' => true]); 
        $contr = DB::table('control_oficial')
        ->where('control_oficial.id_visita', $id_visita)
        ->update(['fecha_fin'=> $fecha_fin])
        ->get();
      
        //$visit= DB::table('visita')
        //->where('id_visita', $id_visita)
        //->update(['estado'=> true])
       // ->get();
             
        
       // return "Fin";
       
       }
    
   }   
  
}
