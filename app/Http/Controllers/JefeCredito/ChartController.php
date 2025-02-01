<?php

namespace sis5cs\Http\Controllers\JefeCredito;
use sis5cs\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PDF;
use PDF2;
use Carbon\Carbon;
use QuickChart;
use DB;
use Auth;



class ChartController extends Controller
{
  public function index(){


    return view('jefecredito.chart.index');//, compact('visita', 'hptam','id'));

  }
  public function vistareporte(Request $request){
    $id=$request->get('id_opcion_estadistica');
    $fecha;
    //$user = Auth::user()->id_users;
    if($id == 1){
      $anio=$request->get('anio');
      $anio2='   ';
      //$anio2=date("Y-m-d", strtotime( $anio));
      //return $anio2;
      $visitaaniototal = DB::table('visita')         //muestra el total de todo
        ->select('fecha_visita')
        ->whereYear('visita.fecha_visita', $anio)
        ->where('visita.aprobado', 1)
        ->where('visita.estado', true)
        //////////->groupBy('fecha_visita')
        ->count(); 
        if($visitaaniototal== null ){
          alert()->info('Atencion','No Hay Datos en esta Fecha Seleccione Otra')->showConfirmButton();
          return redirect()->back(); 
         } 
        $visitaanio = DB::table('visita')               //muestra el total de cada oficial
        ->join('users', 'users.id_users', '=', 'visita.id_users')
        ->select('visita.id_users', DB::raw('count(*) as total'),'users.name')
        ->whereYear('visita.fecha_visita', $anio)
        ->where('visita.aprobado', 1)
        ->where('visita.estado', true)
        ->orderBy('visita.id_users')
        ->groupBy('visita.id_users','users.name')
        ->take(3)
        ->get();
        $tipofecha='Año';
        $salidas = DB::table('visita')
        ->join('users', 'users.id_users', '=', 'visita.id_users')
        ->select('visita.id_users', DB::raw('count(*) as total'),'visita.fecha_visita')
        ///->where('visita.id_users', $id)
        ->whereYear('visita.fecha_visita', $anio)
        ->where('visita.aprobado', 1)
        ->where('visita.estado', true)
        ->groupBy('visita.id_users','visita.fecha_visita')
        ->get(); 
        $salidas2 =collect();
        $total1=0;
        $total2=0;
        $total3=0;
        foreach($salidas as $sa){
          if($sa->id_users == 6){
             $total1++;
          }
          if($sa->id_users == 7){
            $total2++;
         }
         if($sa->id_users == 8){
          $total3++;
       }
       
        } 
        $salidas2->push($total1); 
        $salidas2->push($total2); 
        $salidas2->push($total3); 
        $totalsalidas=$total1+$total2+$total3;
        //$salidastam= sizeof($salidas);
        ///return $salidas;
        return view('jefecredito.chart.vistareporte', compact('visitaaniototal','visitaanio','tipofecha','anio','anio2','id','salidas2','totalsalidas'));
        
           
    }elseif($id== 2){
      $anio=$request->get('mes');
      $anio2='   ';
      $fecha = Carbon::parse($request->mes);
      $mfecha = $fecha->month;
      $afecha = $fecha->year;
      $visitaaniototal = DB::table('visita')         //muestra el total de todo
        ->select('fecha_visita')
        ->whereYear('visita.fecha_visita', $afecha)
        ->whereMonth('visita.fecha_visita', $mfecha)
        ->where('visita.aprobado', 1)
        ->where('visita.estado', true)
        //////////->groupBy('fecha_visita')
        ->count(); 
        if($visitaaniototal== null ){
          alert()->info('Atencion','No Hay Datos en esta Fecha Seleccione Otra')->showConfirmButton();
          return redirect()->back(); 
         } 
        $visitaanio = DB::table('visita')               //muestra el total de cada oficial
        ->join('users', 'users.id_users', '=', 'visita.id_users')
        ->select('visita.id_users', DB::raw('count(*) as total'),'users.name')
        ->whereYear('visita.fecha_visita', $afecha)
        ->whereMonth('visita.fecha_visita', $mfecha)
        ->where('visita.aprobado', 1)
        ->where('visita.estado', true)
        ->orderBy('visita.id_users')
        ->groupBy('visita.id_users','users.name')
        ->take(3)
        ->get();
        $tipofecha='Mes';
        $salidas = DB::table('visita')
        ->join('users', 'users.id_users', '=', 'visita.id_users')
        ->select('visita.id_users', DB::raw('count(*) as total'),'visita.fecha_visita')
        ///->where('visita.id_users', $id)
        ->whereYear('visita.fecha_visita', $afecha)
        ->whereMonth('visita.fecha_visita', $mfecha)
        ->where('visita.aprobado', 1)
        ->where('visita.estado', true)
        ->groupBy('visita.id_users','visita.fecha_visita')
        ->get(); 
        $salidas2 =collect();
        $total1=0;
        $total2=0;
        $total3=0;
        foreach($salidas as $sa){
          if($sa->id_users == 6){
             $total1++;
          }
          if($sa->id_users == 7){
            $total2++;
         }
         if($sa->id_users == 8){
          $total3++;
       }
       
        } 
        $salidas2->push($total1); 
        $salidas2->push($total2); 
        $salidas2->push($total3); 
        $totalsalidas=$total1+$total2+$total3;
        //return $visitaanio;
        return view('jefecredito.chart.vistareporte', compact('visitaaniototal','visitaanio','tipofecha','anio','anio2','id','salidas2','totalsalidas'));
      
    }
    elseif($id== 3){
      //return $request;
      $anio=$request->get('iniciodia');
      $anio2=$request->get('findia');
      $visitaaniototal = DB::table('visita')         //muestra el total de todo
        ->select('fecha_visita')
        ->whereBetween('visita.fecha_visita', [$anio, $anio2])
        ->where('visita.aprobado', 1)
        ->where('visita.estado', true)
        ->count(); 
        if($visitaaniototal== null ){
          alert()->info('Atencion','No Hay Datos en esta Fecha Seleccione Otra')->showConfirmButton();
          return redirect()->back(); 
         } 
        $visitaanio = DB::table('visita')               //muestra el total de cada oficial
        ->join('users', 'users.id_users', '=', 'visita.id_users')
        ->select('visita.id_users', DB::raw('count(*) as total'),'users.name')
        ->whereBetween('visita.fecha_visita', [$anio, $anio2])
        ->where('visita.aprobado', 1)
        ->where('visita.estado', true)
        ->orderBy('visita.id_users')
        ->groupBy('visita.id_users','users.name')
        ->take(3)
        ->get();
        $salidas = DB::table('visita')
        ->join('users', 'users.id_users', '=', 'visita.id_users')
        ->select('visita.id_users', DB::raw('count(*) as total'),'visita.fecha_visita')
        ///->where('visita.id_users', $id)
        ->whereBetween('visita.fecha_visita', [$anio, $anio2])
        ->where('visita.aprobado', 1)
        ->where('visita.estado', true)
        ->groupBy('visita.id_users','visita.fecha_visita')
        ->get(); 
        $salidas2 =collect();
        $total1=0;
        $total2=0;
        $total3=0;
        foreach($salidas as $sa){
          if($sa->id_users == 6){
             $total1++;
          }
          if($sa->id_users == 7){
            $total2++;
         }
         if($sa->id_users == 8){
          $total3++;
       }
       
        } 
        $salidas2->push($total1); 
        $salidas2->push($total2); 
        $salidas2->push($total3); 
        $totalsalidas=$total1+$total2+$total3;
        $tipofecha='Fecha';

        return view('jefecredito.chart.vistareporte', compact('visitaaniototal','visitaanio','tipofecha','anio','anio2','id','salidas2','totalsalidas'));
    }
    elseif($id== 4){
      $anio=$request->get('dia');
      $anio2='   ';
      $visitaaniototal = DB::table('visita')         //muestra el total de todo
        ->select('fecha_visita')
        ->whereDate('visita.fecha_visita', $anio)
        ->where('visita.aprobado', 1)
        ->where('visita.estado', true)
        ->count(); 
        if($visitaaniototal== null ){
          alert()->info('Atencion','No Hay Datos en esta Fecha Seleccione Otra')->showConfirmButton();
          return redirect()->back(); 
         } 
        $visitaanio = DB::table('visita')               //muestra el total de cada oficial
        ->join('users', 'users.id_users', '=', 'visita.id_users')
        ->select('visita.id_users', DB::raw('count(*) as total'),'users.name')
        ->whereDate('visita.fecha_visita', $anio)
        ->where('visita.aprobado', 1)
        ->where('visita.estado', true)
        ->orderBy('visita.id_users')
        ->groupBy('visita.id_users','users.name')
        ->take(3)
        ->get();
        $tipofecha='Fecha';
        $salidas = DB::table('visita')
        ->join('users', 'users.id_users', '=', 'visita.id_users')
        ->select('visita.id_users', DB::raw('count(*) as total'),'visita.fecha_visita')
        ///->where('visita.id_users', $id)
        ->whereDate('visita.fecha_visita', $anio)
        ->where('visita.aprobado', 1)
        ->where('visita.estado', true)
        ->groupBy('visita.id_users','visita.fecha_visita')
        ->get(); 
        $salidas2 =collect();
        $total1=0;
        $total2=0;
        $total3=0;
        foreach($salidas as $sa){
          if($sa->id_users == 6){
             $total1++;
          }
          if($sa->id_users == 7){
            $total2++;
         }
         if($sa->id_users == 8){
          $total3++;
       }
       
        } 
        $salidas2->push($total1); 
        $salidas2->push($total2); 
        $salidas2->push($total3); 
        $totalsalidas=$total1+$total2+$total3;
        return view('jefecredito.chart.vistareporte', compact('visitaaniototal','visitaanio','tipofecha','anio','anio2','id','salidas2','totalsalidas'));
      

    }
  

  }
  public function reporte($id,$anio,$anio2){   
    $now = Carbon::now();    
        if($id == 1){
          //$anio2=date("Y-m-d", strtotime( $anio));
          //return $anio2;
          $visitaaniototal = DB::table('visita')         //muestra el total de todo
            ->select('fecha_visita')
            ->whereYear('visita.fecha_visita', $anio)
            ->where('visita.aprobado', 1)
            ->where('visita.estado', true)
            //////////->groupBy('fecha_visita')
            ->count(); 
            
            $visitaanio = DB::table('visita')               //muestra el total de cada oficial
            ->join('users', 'users.id_users', '=', 'visita.id_users')
            ->select('visita.id_users', DB::raw('count(*) as total'),'users.name')
            ->whereYear('visita.fecha_visita', $anio)
            ->where('visita.aprobado', 1)
            ->where('visita.estado', true)
            ->orderBy('visita.id_users')
            ->groupBy('visita.id_users','users.name')
            ->take(3)
            ->get();
            $salidas = DB::table('visita')
            ->join('users', 'users.id_users', '=', 'visita.id_users')
            ->select('visita.id_users', DB::raw('count(*) as total'),'visita.fecha_visita','users.name')
            ///->where('visita.id_users', $id)
            ->whereYear('visita.fecha_visita', $anio)
            ->where('visita.aprobado', 1)
            ->where('visita.estado', true)
            ->groupBy('visita.id_users','visita.fecha_visita','users.name')
            ->get(); 
            $salidas2 =collect();
            $nombres =collect();
            $total1=0;
            $total2=0;
            $total3=0;
            $name1='Ivan Jorge Romero Ferrufino';
            $name2='Irma Pacheco Marquez';
            $name3='Jaime Bravo Cabrera';
            foreach($salidas as $sa){
              if($sa->id_users == 6){
                 $total1++;
                 $name1= $sa->name;
              }
              if($sa->id_users == 7){
                $total2++;
                $name2= $sa->name;
             }
             if($sa->id_users == 8){
              $total3++;
              $name3= $sa->name;
           }
           
            } 
            $salidas2->push($total1); 
            $salidas2->push($total2); 
            $salidas2->push($total3); 
            $nombres->push($name1); 
            $nombres->push($name2); 
            $nombres->push($name3); 
           
     
            $totalsalidas=$total1+$total2+$total3;

            foreach($visitaanio as $object)
            {
               $total[] =  (array) $object->total ;
               $nombre[] =  (array) $object->name ;
            
            }
            foreach($salidas as $object)
            {
               
               $nombre2[] =  (array) $object->name ;
               
            
            }
            //return $vianio;
            //$tipofecha='Año';
        } elseif($id== 2){
          ///return $anio;
          ///$anio=$request->get('mes');
          $fecha = Carbon::parse($anio);
          $mfecha = $fecha->month;
          $afecha = $fecha->year;
          $visitaaniototal = DB::table('visita')         //muestra el total de todo
            ->select('fecha_visita')
            ->whereYear('visita.fecha_visita', $afecha)
            ->whereMonth('visita.fecha_visita', $mfecha)
            ->where('visita.aprobado', 1)
            ->where('visita.estado', true)
            //////////->groupBy('fecha_visita')
            ->count(); 
            $visitaanio = DB::table('visita')               //muestra el total de cada oficial
            ->join('users', 'users.id_users', '=', 'visita.id_users')
            ->select('visita.id_users', DB::raw('count(*) as total'),'users.name')
            ->whereYear('visita.fecha_visita', $afecha)
            ->whereMonth('visita.fecha_visita', $mfecha)
            ->where('visita.aprobado', 1)
            ->where('visita.estado', true)
            ->orderBy('visita.id_users')
            ->groupBy('visita.id_users','users.name')
            ->take(3)
            ->get();
            $salidas = DB::table('visita')
        ->join('users', 'users.id_users', '=', 'visita.id_users')
        ->select('visita.id_users', DB::raw('count(*) as total'),'visita.fecha_visita','users.name')
        ///->where('visita.id_users', $id)
        ->whereYear('visita.fecha_visita', $afecha)
        ->whereMonth('visita.fecha_visita', $mfecha)
        ->where('visita.aprobado', 1)
        ->where('visita.estado', true)
        ->groupBy('visita.id_users','visita.fecha_visita','users.name')
        ->get(); 
        $salidas2 =collect();
        $nombres =collect();
        $total1=0;
        $total2=0;
        $total3=0;
        $name1='Ivan Jorge Romero Ferrufino';
        $name2='Irma Pacheco Marquez';
        $name3='Jaime Bravo Cabrera';
        foreach($salidas as $sa){
          if($sa->id_users == 6){
             $total1++;
             $name1= $sa->name;
          }
          if($sa->id_users == 7){
            $total2++;
            $name2= $sa->name;
         }
         if($sa->id_users == 8){
          $total3++;
          $name3= $sa->name;
       }
       
        } 
        $salidas2->push($total1); 
        $salidas2->push($total2); 
        $salidas2->push($total3); 
        $nombres->push($name1); 
        $nombres->push($name2); 
        $nombres->push($name3); 
        
        
        $totalsalidas=$total1+$total2+$total3;
            foreach($visitaanio as $object)
            {
               $total[] =  (array) $object->total ;
               $nombre[] =  (array) $object->name ;
            
            }
            foreach($salidas as $object)
            {
               
               $nombre2[] =  (array) $object->name ;
               
            
            }
            //$tipofecha='Mes';
            //return $visitaanio;
            //return view('jefecredito.chart.vistareporte', compact('visitaaniototal','visitaanio','tipofecha','anio','anio2','id'));
          
        }
        elseif($id== 3){
          //return $request;
          $visitaaniototal = DB::table('visita')         //muestra el total de todo
            ->select('fecha_visita')
            ->whereBetween('visita.fecha_visita', [$anio, $anio2])
            ->where('visita.aprobado', 1)
            ->where('visita.estado', true)
            ->count(); 
            $visitaanio = DB::table('visita')               //muestra el total de cada oficial
            ->join('users', 'users.id_users', '=', 'visita.id_users')
            ->select('visita.id_users', DB::raw('count(*) as total'),'users.name')
            ->whereBetween('visita.fecha_visita', [$anio, $anio2])
            ->where('visita.aprobado', 1)
            ->where('visita.estado', true)
            ->orderBy('visita.id_users')
            ->groupBy('visita.id_users','users.name')
            ->take(3)
            ->get();
            $salidas = DB::table('visita')
        ->join('users', 'users.id_users', '=', 'visita.id_users')
        ->select('visita.id_users', DB::raw('count(*) as total'),'visita.fecha_visita','users.name')
        ///->where('visita.id_users', $id)
        ->whereBetween('visita.fecha_visita', [$anio, $anio2])
        ->where('visita.aprobado', 1)
        ->where('visita.estado', true)
        ->groupBy('visita.id_users','visita.fecha_visita','users.name')
        ->get(); 
        $salidas2 =collect();
        $nombres =collect();

        $total1=0;
        $total2=0;
        $total3=0;
        $name1='Ivan Jorge Romero Ferrufino';
        $name2='Irma Pacheco Marquez';
        $name3='Jaime Bravo Cabrera';
        foreach($salidas as $sa){
          if($sa->id_users == 6){
             $total1++;
             $name1= $sa->name;
          }
          if($sa->id_users == 7){
            $total2++;
            $name2= $sa->name;
         }
         if($sa->id_users == 8){
          $total3++;
          $name3= $sa->name;
       }
       
        } 
        $salidas2->push($total1); 
        $salidas2->push($total2); 
        $salidas2->push($total3);
        $nombres->push($name1); 
        $nombres->push($name2); 
        $nombres->push($name3); 
        
        $totalsalidas=$total1+$total2+$total3;
            foreach($visitaanio as $object)
            {
               $total[] =  (array) $object->total ;
               $nombre[] =  (array) $object->name ;
            
            }
            foreach($salidas as $object)
            {
               
               $nombre2[] =  (array) $object->name ;
               
            
            }
            ///$tipofecha='Fecha';
    
            ///return view('jefecredito.chart.vistareporte', compact('visitaaniototal','visitaanio','tipofecha','anio','anio2','id'));
        }
        elseif($id== 4){
          $visitaaniototal = DB::table('visita')         //muestra el total de todo
            ->select('fecha_visita')
            ->whereDate('visita.fecha_visita', $anio)
            ->where('visita.aprobado', 1)
            ->where('visita.estado', true)
            ->count(); 
            $visitaanio = DB::table('visita')               //muestra el total de cada oficial
            ->join('users', 'users.id_users', '=', 'visita.id_users')
            ->select('visita.id_users', DB::raw('count(*) as total'),'users.name')
            ->whereDate('visita.fecha_visita', $anio)
            ->where('visita.aprobado', 1)
            ->where('visita.estado', true)
            ->orderBy('visita.id_users')
            ->groupBy('visita.id_users','users.name')
            ->take(3)
            ->get();
            $salidas = DB::table('visita')
        ->join('users', 'users.id_users', '=', 'visita.id_users')
        ->select('visita.id_users', DB::raw('count(*) as total'),'visita.fecha_visita','users.name')
        ///->where('visita.id_users', $id)
        ->whereDate('visita.fecha_visita', $anio)
        ->where('visita.aprobado', 1)
        ->where('visita.estado', true)
        ->groupBy('visita.id_users','visita.fecha_visita','users.name')
        ->get(); 
        $salidas2 =collect();
        $nombres =collect();
        $name1='Ivan Jorge Romero Ferrufino';
        $name2='Irma Pacheco Marquez';
        $name3='Jaime Bravo Cabrera';
        $total1=0;
        $total2=0;
        $total3=0;
        foreach($salidas as $sa){
          if($sa->id_users == 6){
             $total1++;
             $name1= $sa->name;
          }
          if($sa->id_users == 7){
            $total2++;
            $name2= $sa->name;
         }
         if($sa->id_users == 8){
          $total3++;
          $name3= $sa->name;
       }
       
        } 
        ////return $name2;
        $salidas2->push($total1); 
        $salidas2->push($total2); 
        $salidas2->push($total3); 
        $nombres->push($name1); 
        $nombres->push($name2); 
        $nombres->push($name3); 
        $totalsalidas=$total1+$total2+$total3;
            foreach($visitaanio as $object)
            {
               $total[] =  (array) $object->total ;
               $nombre[] =  (array) $object->name ;
               
            
            }
            foreach($salidas as $object)
            {
               
               $nombre2[] =  (array) $object->name ;
               
            
            }
            //$tipofecha='Fecha';
            ////return view('jefecredito.chart.vistareporte', compact('visitaaniototal','visitaanio','tipofecha','anio','anio2','id'));
          
    
        }
        //return $salidas;
      if(sizeof($total)==2){
        $nombre[2][0]= '';
        $total[2][0]= '';
      }
      elseif(sizeof($total)==1){
        $nombre[1][0]= '';
        $total[1][0]= '';
        $nombre[2][0]= '';
        $total[2][0]= '';

      }

      if(sizeof($nombre2)==2){
        $nombre2[2][0]= '';
        
      }
      elseif(sizeof($nombre2)==1){
        $nombre2[1][0]= '';
        $nombre2[2][0]= '';
        

      }
      if($total1 == 0){
          $total1='';
      }
      

      //return $total1;
    $chart = new QuickChart(array(
        'width' => 950,
        'height' => 700
      ));           
      $chart->setConfig('{
        "type": "outlabeledPie",
        "data": {
          "labels": ["'.$nombre[0][0].'","'.$nombre[1][0].'","'.$nombre[2][0].'"],
          "datasets": [{
              "backgroundColor": ["#36A2EB", "#FF3784", "#f0e813"],
              "data": ['.$total[0][0].','.$total[1][0].','.$total[2][0].']
          }]
        },  
        "options": {
          "plugins": {
            "legend": false,
            "outlabels": {
              "text": "%l %p",
              "color": "white",
              "stretch": 35,
              "font": {
                "resizable": true,
                "minSize": 12,
                "maxSize": 18
              }
            }
          }
        }
        
      }');
          
    $chart3 = new QuickChart(array(
      'width' => 950,
      'height' => 700
    ));           
    $chart3->setConfig('{
      "type": "outlabeledPie",
      "data": {
        "labels": ["'.$name1.'","'.$name2.'","'.$name3.'"],
        "datasets": [{
            "backgroundColor": ["#36A2EB", "#FF3784", "#f0e813"],
            "data": ['.$total1.','.$total2.','.$total3.']
        }]
      },  
      "options": {
        "plugins": {
          "legend": false,
          "outlabels": {
            "text": "%l %p",
            "color": "white",
            "stretch": 35,
            "font": {
              "resizable": true,
              "minSize": 12,
              "maxSize": 18
            }
          }
        }
      }
      
    }');
    
      
    $chart2 =$chart->getShortUrl();
    $path = $chart2;
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data); 
    //return $base64;
    $chart4 =$chart3->getShortUrl();
    $path = $chart4;
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
    $base642 = 'data:image/' . $type . ';base64,' . base64_encode($data); 
    //return $base64;
    $pdf = PDF::loadView('jefecredito.chart.reporte',compact('base64','now','base642','visitaaniototal','visitaanio','anio','anio2','totalsalidas','salidas2','nombres'));
    //,compact('datos','fecha','now','name'));
    //$pdf->setOption('disable-local-file-access', true);
    ///$pdf->setTimeout(3000);
    /////$pdf->setOption('images', true);
    ///$pdf->setOption('disable-smart-shrinking', true);
    //return $pdf->stream();
 return $pdf->download('reportesalidas'. $now .'.pdf');
   

  }
}
