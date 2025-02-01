@extends ('layouts.admin3')
@section ('contenido')
<style> 
  	  #map {
        width: 100%;
      }
     
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
	</style> 
<head>

</head>
<div class="row">
     <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
          <h3>Ruta de Visitas</h3>
          
         
     </div>
     
</div>



<body>
<div class="row">
     <div class="col-lg-17 col-lg-17 col-lg-17 col-lg-12">
          <div  id="map"></div>
     </div>

   
  
</div>

  <table id="other1" border="1"class="table table-bordered table-striped">
  <thead>
  <tr>
    <th>Color</th>
    <th>Visitas</th>
    <th>Numero de Credito</th>
    <th>Datos</th>
    <th>Reportes</th>
  </tr>
  </thead>
  
  <tbody>
  @foreach($idvisitas as $id)
   <tr>
  
     <td>
      <input type="color" class="form-control form-control-color" id="exampleColorInput" value="{{$colores[$loop->iteration]}}" title="Choose your color">
     </td>
    <td>
      <label for="exampleColorInput" class="form-label">Visita {{$loop->iteration}}</label>
    </td> 
    <td>
      <label class="form-label">{{$id->id_credito}}</label>
    </td> 
    <td>
      <label class="form-label">{{$id->nombre}} {{$id->ap_paterno}} {{$id->ap_materno}}</label>
    </td> 

    <td>
      <a href="{{url('/jefecredito/visitas/'.$fecha.'/'.$iduser.'/'.$id->id_visita.'/imprimir')}}" rel="tooltip" title="Reporte Grafico" class="btn btn-success btn-simple btn-xs">
         <i class="fa fa-map" aria-hidden="true"></i>
      </a> 
  
  <a href="{{url('/jefecredito/visitas/'.$fecha.'/'.$iduser.'/'.$id->id_visita.'/imprimir2')}}" rel="tooltip" title="Reporte Datos Usuario" class="btn btn-success btn-simple btn-xs">
  <i class="fa fa-sticky-note-o" aria-hidden="true"></i></i> 
      </a> 
  </td>   
  </tr>
  @endforeach
  <tr>
     <td><input type="color" class="form-control form-control-color" id="exampleColorInput" value="#0a0a0a" title="Choose your color">
     </td>
     <td> <label for="exampleColorInput" class="form-label">Ubicacion de Fotos Tomadas</label></td>
  </tr>
  <tr>
  </tr>
 
  </tbody>
  </table>
</body>

@push ('scripts')


  
       
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDVomCQZTYVQSRGPsG6cQPLsoZqYWdZq0w"></script>

<script type="text/javascript">
var geocoder;
var map;
var directionsDisplay;
var directionsService = new google.maps.DirectionsService();
var locations2 = [
 		
['GATO1',	-19.55821159,-65.76757173,1],
['GATO1',	-19.55821336,-65.76755787,2],
['GATO1',	-19.55871308,-65.76660179,3],
['GATO1',	-19.55842306,-65.76579276,4],
['GATO1',	-19.55821709,-65.76546266,5],
['GATO1',	-19.55788537,-65.76452517,6],
['GATO1',	-19.55767711,-65.76377186,7],
['GATO1',	-19.5574823,-65.7630506,8],
['GATO1',	-19.55729604,-65.76287325,9],
['GATO1',	-19.55725359,-65.76256885,10],
['GATO1',	-19.55723629,-65.76256195,11],
['GATO1',	-19.55733268,-65.76261452,12],
['GATO1',	-19.55879319,-65.76225718,13],
['GATO1',	-19.55914404,-65.7622528,14],
['GATO1',	-19.5613191,-65.76196797,15],
['GATO1',	-19.56296938,-65.76175153,16],
['GATO1',	-19.56461944,-65.76190336,17],
['GATO1',	-19.56530587,-65.76343742,18],
['GATO1',	-19.56416298,-65.76532497,19],
['GATO1',	-19.56422049,-65.76562688,20],
['GATO1',	-19.56462296,-65.76671834,21],
['GATO1',	-19.56563807,-65.76702479,22],
['GATO1',	-19.56693148,-65.76795965,23],
['GATO1',	-19.5686926,-65.76762693,24],
['GATO1',	-19.56964467,-65.7674035,25],
['GATO1',	-19.5709553,-65.76708964,26],
['GATO1',	-19.58921222,-65.74899397,27]


  
];//puntos que muestran la api 
var locations=
        [
          @for(  $k = 0 ; $k < $cantidverificado ; $k++)
                @foreach ($latlong27[$k] as $ub)
                  { lat: "{{ $ub->latitud }}", lng: "{{ $ub->longitud }}"},
                @endforeach
            @endfor
        ];
        var props = 
        [
            @for(  $j = 0 ; $j < $tamubicacionvisita ; $j++)
                @foreach ($ubicacionvisita[$j] as $vi)
                  { lat: "{{ $vi->latitud }}", lng: "{{ $vi->longitud }}"},
                @endforeach
            @endfor
        ];
        
        var todo=
        [
          @for(  $k = 0 ; $k < $tamubicacionvisitatodo ; $k++)
                @foreach ($ubicacionvisitatodo[$k] as $ub)
                  { lat: "{{ $ub->latitud }}", lng: "{{ $ub->longitud }}"},
                @endforeach
            @endfor
        ];
        
         var camara=
        [
          @for( $l = 0 ; $l < $tamfotoubicacion2 ; $l++)
                @foreach ($fotoubicacion2[$l] as $fo)
                  { lat: "{{ $fo->latitud }}", lng: "{{ $fo->longitud }}"},
                @endforeach
          @endfor
        ];
        var icons=[ 
            "{{asset('images/rojo.png')}}",
            "{{asset('images/rojo.png')}}",
            "{{asset('images/morado.png')}}",
            "{{asset('images/morado.png')}}",
            "{{asset('images/amarillo.png')}}",
            "{{asset('images/amarillo.png')}}",
            "{{asset('images/azul.png')}}",
            "{{asset('images/azul.png')}}",
            "{{asset('images/verde.png')}}",
            "{{asset('images/verde.png')}}",
            "{{asset('images/negro.png')}}",
            "{{asset('images/negro.png')}}",
            "{{asset('images/celeste.png')}}",
            "{{asset('images/celeste.png')}}",
            "{{asset('images/rosa.png')}}",
            "{{asset('images/rosa.png')}}",
            "{{asset('images/naranja.png')}}",
            "{{asset('images/naranja.png')}}",
            "{{asset('images/rosado.png')}}",
            "{{asset('images/rosado.png')}}",
            

        ];
        var colores2=['#c73730','#563d7c','#c7d419','#1f30c4','#24a634','#0a0a0a','#29c5d6','#db2acf','#e8621a','#f593aa'];
        var prueba= [{holos:34},{holos:23}];
       var nombre=["inicio","fin","inicio","fin","inicio","fin","inicio","fin","inicio","fin","inicio","fin","inicio","fin","inicio","fin","inicio","fin","inicio","fin"];
        var visita=["Visita 1:inicio","Visita 1:fin","Visita 2:inicio","Visita 2:fin",
                     "Visita 3:inicio","Visita 3:fin","Visita 4:inicio","Visita 4:fin","Visita 5:inicio","Visita 5:fin","Visita 6:inicio","Visita 6:fin"
                     ,"Visita 7:inicio","Visita 7:fin","Visita 8:inicio","Visita 8:fin","Visita 9:inicio","Visita 9:fin","Visita 10:inicio","Visita 10:fin"];
//var imgg ="{{asset('images/rojo2.png')}}"
        //var letra= "asdadasdasd";  
        var trazar = new Array();
        var trazo = new Array();  
       

        
        
function initialize() {
  directionsDisplay = new google.maps.DirectionsRenderer();


  var map = new google.maps.Map(document.getElementById('map'), {
    zoom: 10,
    center: new google.maps.LatLng(-19.589041508422916, -65.74887769445895)
  });
  directionsDisplay.setMap(map);
  var infowindow = new google.maps.InfoWindow();
  var marker, i;
  var request = {
    travelMode: google.maps.TravelMode.DRIVING
  };
  for (i = 0; i < locations.length; i++) {
    marker = new google.maps.Marker({
      position: new google.maps.LatLng(locations[i].lat, locations[i].lng),
    });

    google.maps.event.addListener(marker, 'click', (function(marker, i) {
      return function() {
        infowindow.setContent(locations[i]);
        infowindow.open(map, marker);
      }
    })(marker, i));

    if (i == 0) request.origin = marker.getPosition();
    else if (i == locations.length - 1) request.destination = marker.getPosition();
    else {
      if (!request.waypoints) request.waypoints = [];
      request.waypoints.push({
        location: marker.getPosition(),
        stopover: true
      });
    }

  }
  directionsService.route(request, function(result, status) {
    if (status == google.maps.DirectionsStatus.OK) {
      directionsDisplay.setDirections(result);
    }
  });

  

  for( var i = 0 ; i < todo.length ; i++){
               
               var latlango = new google.maps.LatLng (todo[i].lat, todo[i].lng);
               trazo.push(latlango);
            
               var colores2=['#c73730','#563d7c','#c7d419','#1f30c4','#24a634','#0a0a0a'];
                var flightPath2 = new google.maps.Polyline({
                  
                 path: trazo,
                 map: map,
                 geodesic: true,
                 strokeColor: '#c73730',
                 strokeOpacity: 1.0,
                 strokeWeight: 2,
                  
                });
               
              
             }
             for( var i = 0 ; i < camara.length ; i++){
                var latlang2 = new google.maps.LatLng (camara[i].lat, camara[i].lng);
                var var_marker2 = new google.maps.Marker({
                   position: latlang2,
                   map: map,
                   icon: icons[11]
                   
               });
             }
             for( var i = 0 ; i < todo.length ; i++){
               var latlang = new google.maps.LatLng (props[i].lat, props[i].lng);
               //trazar.push(latlang);
               var marker3 = new google.maps.Marker({
                   position: latlang,
                   map: map,
                   icon: icons[i],
                   label: nombre[i],
                   title: nombre[i]
                   
               });

             }
                          
}
google.maps.event.addDomListener(window, "load", initialize);
 

</script>
@endpush


@include('sweetalert::alert')
@push ('scripts')
<script>
  $('#liAdmin').addClass("treeview active");
  $('#liAdmin_croquis').addClass("active");
</script>

<script type="text/javascript">
  //function actualizar(){location.reload(true);}
//Función para actualizar cada 4 segundos(4000 milisegundos)
  //setInterval("actualizar()",4000);

  

</script>

@endpush
@endsection