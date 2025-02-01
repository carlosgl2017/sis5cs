@extends ('layouts.admin3')
@section ('contenido')
<head>

</head>
<div class="row">
     <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
          <h3>Ubicacion de Oficial</h3>
          
         
     </div>
</div>


<div id="recargar">
<body>
<div class="row">
     <div class="col-lg-17 col-md-17 col-sm-17 col-xs-12">
          <div  id="map-container"></div>
          
     </div>
  
</div>
</body>



</div>


     




@include('sweetalert::alert')
@push ('scripts')
<script>
  $('#liAdmin').addClass("treeview active");
  $('#liAdmin_croquis').addClass("active");
</script>

<script type="text/javascript">
  //function actualizar(){
    //location.reload(true);}
//Función para actualizar cada 4 segundos(4000 milisegundos)
  //setInterval("actualizar()",15000);
 
  
</script>
<script type="text/javascript">

function holos() {
 


  <?php
        $existe_conyugue = \sis5cs\Persona::where('id_persona', 2)->get();
        alert("hola");
        ?>
}
setInterval("holos()",4000);


</script>
  
       
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDVomCQZTYVQSRGPsG6cQPLsoZqYWdZq0w"></script>

<script type="text/javascript">

var j=0;
var locations = [ [ -19.5618095397949 ,  -65.7627487182617],
                  [ -19.5622310638428 , -65.7633209228516 ],
                  [ -19.5593911,  -65.7679346 ],
                ];
	function init_map() {
    
    var var_location = new google.maps.LatLng(locations[2][0] ,locations[2][1]);
        var var_mapoptions = {
          center: var_location,
          zoom: 18
        };

        
        var props = [
  @foreach ($visita as $vi)
    { lat: "{{ $vi->latitud }}", lng: "{{ $vi->longitud }}"},
        @endforeach
      ];
        
        var var_map = new google.maps.Map(document.getElementById("map-container"),
            var_mapoptions);
            for( var i = 0 ; i < props.length ; i++){
      var latlang = new google.maps.LatLng (props[i].lat, props[i].lng);
      
      var var_marker = new google.maps.Marker({
      position: latlang,
      map: var_map
      });
            }
           
          
    var_marker.setMap(var_map, locations); 
    
      }
      
      google.maps.event.addDomListener(window, 'load', init_map);

      const allScripts = document.getElementsByTagName( 'map-container' );
      [].filter.call(
      allScripts, 
      ( scpt ) => scpt.src.indexOf( 'key=AIzaSyDVomCQZTYVQSRGPsG6cQPLsoZqYWdZq0w' ) >= 0
      )[ 0 ].remove();

 window.google = {};
 

</script>
@endpush
@endsection