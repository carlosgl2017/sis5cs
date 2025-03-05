<?php

namespace sis5cs\Http\Controllers\Oficial;
use DB;
use File;
use PDF;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Image;
use Session;
use sis5cs\CategoriaFoto;
use sis5cs\SeguimientoFoto;
use sis5cs\CategoriaCroquis;
use sis5cs\Foto;
use sis5cs\Categoria;
use sis5cs\Croquis;
use sis5cs\Persona;
use sis5cs\Credito;
use sis5cs\User;
use sis5cs\Http\Controllers\Controller;
use sis5cs\Http\Requests\FotoFormRequest;
use sis5cs\Http\Requests\UserFormRequest;
use Carbon\Carbon;
use Codedge\Fpdf\Fpdf\Fpdf;

class FotoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {    //el index busca el tipo de pdf a realizar
        //return $request;
        $id_persona= session('id_persona');
        $id_credito = session('id_credito');
        if ($id_persona  == null && $id_credito  == null) 
        {
            alert()->info('Info', 'Seleccione un socio y Credito')->showConfirmButton();
            return redirect('oficial/dashboard/');
        }
        
        $id_opcion_pdf=$request->get('id_opcion_pdf');
        $id_opcion_carpeta=$request->get('id_opcion_carpeta');
        $idfoto=session('id_credito');
        $fotos = DB::table('foto')
        ->join('seguimiento_fotografico', 'seguimiento_fotografico.id_seguimiento_foto', '=', 'foto.id_seguimiento_foto')
        ->select('foto.*')
        ->where ('seguimiento_fotografico.id_credito', session('id_credito'))
        ->where ('seguimiento_fotografico.id_seguimiento_foto',$id_opcion_carpeta)
        ->get();
       
        switch($id_opcion_pdf){
           
            case(1):
                
                return view('oficial.foto.prueba2')->with(compact('fotos','idfoto'));
                break;
            case(2):
                $croquis = DB::table('categoria_croquis')
                ->join('croquis', 'croquis.id_categoria_croquis', '=','categoria_croquis.id_categoria_croquis' )
                ->select('categoria_croquis.id_categoria_croquis','categoria_croquis.categoria')
                ->where('croquis.id_persona', session('id_persona'))
                ->get();
                return view('oficial.foto.vistacroquis2')->with(compact('fotos','idfoto','id_opcion_pdf','croquis'));
                break;
            case(3):
                $id_opcion_carpeta2=$request->get('id_opcion_carpeta2');
               
                   $fotos2 = DB::table('foto')
                  ->join('seguimiento_fotografico', 'seguimiento_fotografico.id_seguimiento_foto', '=', 'foto.id_seguimiento_foto')
                  ->select('foto.*')
                  ->where ('seguimiento_fotografico.id_credito', session('id_credito'))
                  ->where ('seguimiento_fotografico.id_seguimiento_foto',$id_opcion_carpeta2)
                   ->get();
                
                return view('oficial.foto.vistaantesdespues2')->with(compact('fotos','idfoto','fotos2'));
                break;
            case(100);
                     alert()->info('Atencion','Seleccione una Opcion')->showConfirmButton();
                     return redirect()->back();
                break;   
            default:
                break; 
            }
            
            $id_opcion_carpeta=$request->get('id_opcion_carpeta');
            $seguimientofoto=DB::table('seguimiento_fotografico')
            ->select('seguimiento_fotografico.*')
            ->where('seguimiento_fotografico.id_credito',session('id_credito'))
            ->get();
        
        return view('oficial.foto.index')->with(compact('idfoto','seguimientofoto'));
    }
    public function fotodetalle(Request $request)
    {
          
         return view('oficial.foto.create');
        
    }
      
    
    public function prueba2(Request $request)
    { 
        
        $hp= $request->get('id_foto');
        if(count($request->all())== 1){
            alert()->info('Atencion','Seleccione  Alguna Fotografia')->showConfirmButton();
            return redirect()->back(); 

        } 
        if($hp > 2){
            $hptam= sizeof($hp);         //este es el numero de objetos que tiene el array
            $coll =collect() ;    //creacion de una nueva collection
            $titulo= $request-> input('titulo'); 
            for($i =0;$i<$hptam;$i++){
            $foto = DB::table('foto')
            ->where ('id_foto', $hp[$i])
            ->get();
            $coll->push($foto); 
            $nombre = DB::table('persona')
            ->select('nombre','ap_paterno','ap_materno')
            ->where ('id_persona',  session('id_persona'))
            ->get();
            $tipocred = DB::table('tipo_credito')
            ->join('credito', 'credito.id_tcredito', '=', 'tipo_credito.id_tcredito')
            ->select('tipo_credito')
            ->where ('credito.id_credito',  session('id_credito'))
            ->get();
            $now = Carbon::now();
            $id_user = Auth::user()->id_users;
            $users = DB::table('users')
                ->select('name')
                ->where('id_users', $id_user)
                ->get();

                     //introducimos los objetos en la nueva collection       
            }
            if($hptam > 2 && $hptam <13 ){
               //$pdf = PDF::loadView('oficial.foto.holos');
               // return $pdf->download('invoice.pdf');
                //return view('oficial.foto.createpdf')->with(compact('coll','hptam','titulo','nombre','tipocred','now','users'));
              //  $data= ['coll'=>$coll,'hptam'=>$hptam,'titulo'=>$titulo,'nombre'=>$nombre,'tipocred'=>$tipocred,'now'=>$now,'users'=>$users];
               // $pdf= PDF::loadView('oficial.foto.createpdf',$data);
           // $pdf= PDF::loadView('oficial.foto.createpdf',compact('coll','hptam','titulo','nombre','tipocred','now','users'));
            $pdf = PDF::loadView('oficial.foto.createpdf',compact('coll','hptam','titulo','nombre','tipocred','now','users'));
           
            
            //return $pdf->download('holos.pdf');
            return $pdf->stream();}
            else{
                                //el if controla que no se  selecciono ni una foto
                    alert()->info('Atencion','Seleccione de 3 a 12  fotos')->showConfirmButton();
                    return redirect()->back();           
            }
        }
       
    }
    


    public function create($id)
    {
        
        $categorias = CategoriaFoto::All();
        $fotos = DB::table('foto')
        ->join('credito', 'credito.id_credito', '=', 'foto.id_credito')
        ->select('foto.*')
        ->where ('credito.id_credito',session('id_credito'))
        ->where('foto.id_persona', session('id_persona'))
        ->get();
        $idfoto= session('id_credito');
        return view('oficial.foto.create')->with(compact('categorias','fotos','idfoto'));
       
    }

    public function store(FotoFormRequest $request)
    {   
         
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
         $fotoseguimiento->id_credito =session('id_credito');
         $notification = 'Excelente  se Creo una Nueva Carpeta y se Agregaron Nuevas Fotos';
         $fotoseguimiento->save();
        for($i =0;$i<$tam;$i++){
        $foto = new Foto();
        $foto->archivo = $urlimage[$i];
        $foto->detalle =$request ->input('detalle');
        $foto->id_seguimiento_foto=$fotoseguimiento->id_seguimiento_foto;
        $foto->save();
        
        }
         return redirect('oficial/foto/intento')->with(compact('notification'));     
    }
     
    public function edit($id, $id2)
    {
        $i=$id2;
        $foto = Foto::find($id);
        $categoria = CategoriaFoto::All();
        return view('oficial.foto.edit')->with(compact('categoria', 'foto','i'));
    }

    public function descarga($id)
    {
        $foto = Foto::find($id);
        $pathtoFile=public_path().'/images/fotos/'.$foto->archivo;
        return response()->download($pathtoFile);        
    }

    public function update(Request $request, $id, $id2)
    {
           
        if (Input::hasFile('fotografia')) {
            $path = public_path() . '/images/fotos/';
            $imagenOriginal = $request->file('fotografia');
            $imagen = Image::make($imagenOriginal);
            $temp_name = uniqid() . '.' . $imagenOriginal->getClientOriginalExtension();
            $imagen->resize(800, 600);

            $foto = Foto::findOrFail($id);
            $foto->id_seguimiento_foto = $id2;
            $foto->detalle = $request->get('detalle');
            $anterior_file = $foto->archivo;
            $foto->archivo = $temp_name;
            $foto->update(); //metodo se encarga de ejecutar un insert sobre la tabla
            if ($foto->save()) {
            //mover nuevo archivo al directorio
                $imagen->save($path . $temp_name, 100);
            //eliminar archivo antiguo del directorio
                $direccion = public_path() . '/images/fotos/' . $anterior_file;
                $deleted = File::delete($direccion);
            }
            $foto = Foto::findOrFail($id);
            $foto->id_seguimiento_foto = $id2;
            $foto->detalle = $request->get('detalle');
            $foto->update();
        }     
        $notification = 'Exelente su fotografia se ha modificado correctamente'; 
       // return back()->with(compact('notification'));

        return redirect('oficial/foto/intento')->with(compact('notification'));

    }

    public function destroy($id)
    {    
    
      $foto=Foto::find($id); 
      $direccion=public_path().'/images/fotos/'.$foto->archivo;
      $deleted=File::delete($direccion);
      $foto->delete(); //delete
      $notification= 'Exelente la fotografía se elimino correctamente'; 
      return back()->with(compact('notification'));
    }
    // public function destroy2($id2)
   // {    
       
    //  $fotoid=SeguimientoFoto::find($id2); 
     // $fotoid->delete(); //delete
    //  $notification= 'Excelente la  Lista de Fotos se elimino correctamente'; 
    //  return back()->with(compact('notification'));
    //}

    public function intento()
    {
        $idfoto= session('id_credito');
        $seguimientofoto = DB::table('seguimiento_fotografico')
        ->join('foto', 'foto.id_seguimiento_foto', '=', 'seguimiento_fotografico.id_seguimiento_foto')
        ->select('seguimiento_fotografico.*', DB::raw("count(seguimiento_fotografico.id_seguimiento_foto) as count"))
        ->where ('seguimiento_fotografico.id_credito',session('id_credito'))
        ->groupby('seguimiento_fotografico.id_seguimiento_foto')
        ->get();
        //return $seguimientofoto;
        return view('oficial.foto.intento')->with(compact('seguimientofoto','idfoto'));      
    }
    
    public function vistacroquis2(Request $request, $id){
        if (session('id_persona') == null) {
            flash()->addWarning('Seleccione un crédito.');
            return redirect('oficial/dashboard/');
        }       
        
        $id_cateogria_croquis= $request->get('id_tipocroquis');
        
        $croquis = DB::table('categoria_croquis')
        ->join('croquis', 'croquis.id_categoria_croquis', '=','categoria_croquis.id_categoria_croquis' )
        ->select('categoria_croquis.id_categoria_croquis','categoria_croquis.categoria')
        ->where('croquis.id_persona', session('id_persona'))
        ->get();
        $hp= $request->get('id_foto');
        $idfotoooo= $request->id_foto[0]; ///agregue desde aqui
        $idcarpeta=DB::table('foto')
        ->select('foto.id_seguimiento_foto')
        ->where('foto.id_foto',$idfotoooo)
        ->get();
        $ubicacion_mapa= DB::table('seguimiento_fotografico')
        ->join('foto', 'foto.id_seguimiento_foto', '=','seguimiento_fotografico.id_seguimiento_foto' )
        ->select('seguimiento_fotografico.latitud','seguimiento_fotografico.longitud')
        ->where('seguimiento_fotografico.id_seguimiento_foto',$idcarpeta[0]->id_seguimiento_foto)
        ->limit(1)
        ->get();
        //$hptam= sizeof($hp);
        if($hp > 2 ){
            $hptam= sizeof($hp);
                if($hptam == 2){
                    $coll =collect() ;    //creacion de una nueva collection
                    $titulo= $request-> input('titulo'); 
                    $direccion= $request-> input('direccion');
                    $croquis= DB::table('croquis')
                    ->select('croquis.latitud','croquis.longitud')
                    ->where('id_categoria_croquis', $id_cateogria_croquis)
                    ->where('id_persona', session('id_persona'))
                    ->get();
                    $nombre=DB::table('persona')
                    ->select('nombre','ap_paterno','ap_materno')
                    ->where('id_persona', session('id_persona'))
                    ->get();
                    for($i =0;$i<$hptam;$i++){
                    $foto = DB::table('foto')
                    ->where ('id_foto', $hp[$i])
                    ->get();
                    $coll->push($foto);   }
                    $id_user = Auth::user()->id_users;
                    $users = DB::table('users')
                        ->select('name')
                        ->where('id_users', $id_user)
                        ->get();
                        $now = Carbon::now();
                    return view('oficial.foto.createdomiciliopdf')->with(compact('coll','hptam','croquis','titulo','direccion','nombre','users','now','ubicacion_mapa' ));
                }
                     else{
                                //el if controla que no se  selecciono ni una foto
                    alert()->info('Atencion','Seleccione Solo 2 Fotografias')->showConfirmButton();
                    return redirect()->back();           
                    }
        } 
        else{ 
            alert()->info('Atencion','Seleccione  2 Fotografias')->showConfirmButton();
            return redirect()->back();   
         }  
       
        
    }

    public function vistaantesdespues2(Request $request){
        if (session('id_persona') == null) {
            flash()->addWarning('Seleccione un crédito.');
            return redirect('oficial/dashboard/');
        } 
         
        
        if(count($request->all())== 3){
            alert()->info('Atencion','Seleccione  Alguna Fotografia')->showConfirmButton();
            return redirect()->back(); 

        }   
        $hp1= $request->get('id_foto1');
        $hp2= $request->get('id_foto2');
        if(count($hp1)!= 3 ||count($hp2)!= 3){
            alert()->info('Atencion','Seleccione  3 Fotografias de Cada Tabla')->showConfirmButton();
            return redirect()->back(); 

        } 

        if($hp1 > 2 && $hp2 > 2){
            
            $hptam1= sizeof($hp1);
            $hptam2= sizeof($hp2);          //este es el numero de objetos que tiene el array
                
            $coll1 =collect() ;   //creacion de una nueva collection
            $coll2 =collect() ;    
            $titulo= $request-> input('titulo'); 
            for($i =0;$i<$hptam1;$i++){
            $foto1 = DB::table('foto')
            ->where ('id_foto', $hp1[$i])
            ->get();
            $foto2 = DB::table('foto')
            ->where ('id_foto', $hp2[$i])
            ->get();
            $coll1->push($foto1); 
            $coll2->push($foto2); 
            }
            $id_user = Auth::user()->id_users;
            $users = DB::table('users')
                ->select('name')
                ->where('id_users', $id_user)
                ->get();
            $tipocred = DB::table('tipo_credito')
            ->join('credito', 'credito.id_tcredito', '=', 'tipo_credito.id_tcredito')
            ->select('tipo_credito')
            ->where ('credito.id_credito',  session('id_credito'))
            ->get();
            $now = Carbon::now();
            $nombre = DB::table('persona')
            ->select('nombre','ap_paterno','ap_materno')
            ->where ('id_persona',  session('id_persona'))
            ->get();
           
            $hptam3 = $hptam1 +$hptam2;
            if($hptam1 == 3 && $hptam2 == 3){
                $pdf= PDF::loadView('oficial.foto.createantesdespuespdf',compact('coll1','coll2','hptam3','titulo','users','now','tipocred','nombre'));
                //$pdf->setPaper('a4' , 'landscape'); //con esta linea se voltea de forma horizaontal la pag
                $pdf->setPaper('folio');
                //return $pdf->download();
                return $pdf->stream();}
                    else{
                         alert()->info('Atencion','Seleccione Solo 3 Fotografias de Cada Tabla')->showConfirmButton();
                        return redirect()->back();           
                        }//introducimos los objetos en la nueva collection       
            }
            
               
    
        
           
       
    }
    public function listafoto($id){
        $idfoto=session('id_credito');
        $fotos= DB::table('foto')
        ->join('seguimiento_fotografico', 'foto.id_seguimiento_foto', '=', 'seguimiento_fotografico.id_seguimiento_foto')
        ->select('foto.*','seguimiento_fotografico.descripcion')
        ->where('seguimiento_fotografico.id_credito',session('id_credito'))
        ->where('seguimiento_fotografico.id_seguimiento_foto',$id)
        ->get();
        
        $fotos2= DB::table('foto')
        ->join('seguimiento_fotografico', 'foto.id_seguimiento_foto', '=', 'seguimiento_fotografico.id_seguimiento_foto')
        ->select('seguimiento_fotografico.descripcion')
        ->where('seguimiento_fotografico.id_credito',session('id_credito'))
        ->where('seguimiento_fotografico.id_seguimiento_foto',$id)
        ->take(1)
        ->get();
        $id2= $id;
        $id_seguimiento_foto= $id;
        if (count($fotos)) { 
            //return "Si hay fotos";
            return view('oficial.foto.listafoto')->with(compact('fotos','idfoto','id2','fotos2'));
            
            
        }
        else{
            //return "NO hay fotos";
            //$notification = 'Esta Carpeta no contiene Fotografias Agregue Algunas'; 
            alert()->info('Atencion','Esta Carpeta no contiene Fotografias Agregue Algunas')->showConfirmButton();
            return view('oficial.foto.agregar')->with(compact('id_seguimiento_foto'));
        }
        
       // return view('oficial.foto.listafoto')->with(compact('fotos','idfoto','id2','fotos2'));

    }

    public function agregar($id){
         $id_seguimiento_foto =$id;
         //return "holos";
         
        return view('oficial.foto.agregar')->with(compact('id_seguimiento_foto'));

       }

       public function storefoto(FotoFormRequest $request,$id)
       {   
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
        for($i =0;$i<$tam;$i++){
        $foto = new Foto();
        $foto->archivo = $urlimage[$i];
        $foto->detalle =$request ->input('detalle');
        $foto->id_seguimiento_foto=$id;
        $foto->save();
         
        }
        
        //return $foto;
        $notification= 'Exelente se ha guardado la foto correctamente a la Carpeta';
   
        //return view('oficial.foto.listafoto')->with(compact('notification','id2'));
       // return redirect('oficial/foto/listafoto')->with(compact('notification'));
        //return back()->with(compact('notification'));
         return redirect('oficial/foto/intento')->with(compact('notification'));      
    }

    public function register(){
        //return(session('id_persona'));
        return view('oficial.foto.register');
        
    }
    public function createregister(Request $request){
        //return(session('id_persona'));
    
        $this->validate($request, [
            'name' => 'string|required',
            'email' => 'string|required',
            'password' => 'string|required|confirmed'
            
        ]); 
         $email= $request->get('email');
         $email2 = User::where('email', '=', $email)->first();
         //si es null  significa que es un nuevo registro         
         if($email2 !=null){
            $email2 = User::where('email', '=', $email)->first()->email;
             if($email == $email2){
                 $notification= 'Este email ya esta en Uso Registre Otro';
                 return back()->with(compact('notification'));
             }
         }
         
         $id_persona = session('id_persona');
         
         $user = User::where('id_persona', '=', session('id_persona'))->first();
         if ($user != null) {
            $notification= 'Esta Persona ya cuenta con una Cuenta en la App Verifique la Lista de Registros';
   
            return back()->with(compact('notification'));
         }
         $id_rol= 10 ;
         $user = new User();
         $user->name = $request ->input('name');
         $user->email =$request ->input('email');
         $user->password =bcrypt($request ->input('password'));
         $user->id_rol= $id_rol;
         $user->id_persona=  $id_persona;  
         $user->save();
         $notification= 'Excelente se ha creado el usuario correctamente';
         return redirect('oficial/foto/listaregister')->with(compact('notification'));
        // return back()->with(compact('notification'));
         //return view('oficial.foto.index')->with(compact('notification'));
    }
    public function listaregister(){
        //return(session('id_persona'));
        $users= DB::table('users')
        ->join('persona', 'users.id_persona', '=', 'persona.id_persona')
        ->select('users.*','persona.nombre','persona.ap_paterno','persona.ap_materno')
        //->where('id_persona',2)
        ->where('id_rol',10)
        ->Orwhere('id_rol',5)
        ->get();
        return view('oficial.foto.listaregister')->with(compact('users'));            
    }

    public function deleteuser($id)
    {    
       
      $user=User::find($id); 
      $user->delete(); //delete
      $notification= 'Excelente  se elimino la cuenta  correctamente'; 
      return back()->with(compact('notification'));
    }
    public function edituser($id){
       
        $users= DB::table('users')
        ->select('users.*')
        //->where('id_persona',2)
        ->where('id_users',$id)
        ->get();

        return view('oficial.foto.edituser')->with(compact('id','users'));

    }
    public function updateuser(Request $request,$id){
      

         $this->validate($request, [
            'name' => 'string|required',
            'email' => 'string|required',
            'password' => 'string|required|confirmed'
            
        ]); 
        $email= $request->get('email');
        $email2 = User::where('email', '=', $email)->first();
       
        //si es null  significa que es un nuevo registro         
        if($email2 !=null){
           $email2 = User::where('email', '=', $email)->first()->email;
           $nouser = User::where('id_users', $id)->get();
          
            
            if($email == $email2 && $nouser == null ){
                $notification= 'Este email ya esta en Uso Registre Otro';
                return back()->with(compact('notification'));
            }
        }
        $user = User::findOrFail($id);
        $user-> name = $request->input('name');
        $user-> email = $request->input('email');
        $user-> password = bcrypt($request->input('password'));
        $user->update();
        $notification ="Se Actualizo los Datos con Exito";
        return redirect('oficial/foto/listaregister')->with(compact('notification'));    

    }
    public function estado($id){

        $rol = User::where('id_users', '=', $id)->first()->id_rol;
        if($rol == 10){
        $user = User::findOrFail($id);
        $user-> id_rol = "5";
        $user->update();
        $notification ="Se Deshabilito al Usuario";
        }
        elseif($rol == 5){
        $user = User::findOrFail($id);
        $user-> id_rol = "10";
        $user->update();
        $notification ="Se Habilito al Usuario";

        }
        
        return redirect('oficial/foto/listaregister')->with(compact('notification'));
        


    }

}
