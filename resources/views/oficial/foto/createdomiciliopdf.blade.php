@extends ('layouts.admin3')
@section ('contenido')
<html >
<div id="imp1">
    <head>
        <table  border="0"  width="100%" eight="70%">
          <tr> 
           <td>
            <em>
              <i style="color:#B73451"; >Reporte Generado en Fecha: {{$now}}</i><br>
              <a>Reporte Generado por :  {{$users[0]->name}} </a>
              </em>
              </td>
              <td   valign="top" align="right">    <img src="{{asset('images/logo1.png')}}"  height="50px" width="50px" class="img-thumbnail" >
                    <small><em><i style="color:#B73451"; ><br>Potosi-Bolivia </br></i></em></small> 
            </td> 
          </tr>
          <table  align="center" >   
     <tr><td>   <i  style="color:#3E3E8B";><ins><font size="5" FACE="times new roman">{{$titulo}}</font> </ins></i></td></tr>
         </table>
</table>

    </head>
    <body>
        <table  align="center"  width="70%" eight="70%" >
            <tr><td align="left">
        @foreach ($nombre as $no)   
        <i  style="color:#3E3E8B";><pre style="white-space: normal"><font size="3" FACE="times new roman"><strong>NOMBRE:</strong> {{$no->nombre}}  {{$no->ap_paterno}}  {{$no->ap_materno}}</font> </pre></i>    
        @endforeach</td></tr>
        <tr><td>
       
        <i  style="color:#3E3E8B";><pre style="white-space: normal"><font size="3" FACE="times new roman"><strong>DIRECCION:</strong> {{$direccion}} </font></pre></i>
        
</tr></td>
       </table>
        <form >
        <table border="0" style="width:100%"   cellspacing="3" cellpadding="3" >
          
        @switch($hptam)  
         @case (2)
         @for($i=0 ;$i<$hptam;$i++)
           @switch($i)
           @case(0)
            <th style="text-align: center">UBICACION DE LA DIRECCION</th>
            <tr >           
           
               <td   rowspan="2" id="map-container" > 
               </td>

           

            


                @foreach($coll[$i] as $pe)  
                 <td align="right"  width="300" heigth="300"><img src="{{asset('images/fotos/'.$pe->archivo)}}" alt="{{ $pe->archivo}}" height="300px" width="300px" class="img-thumbnail"></td>   
                 </tr>
                 @endforeach
             @break   
                
            </tr>
            
            <tr>
            <th style="text-align: center">FOTOGRAFIAS</th>
            @case(1)
               @foreach($coll[$i] as $pe)  
                <td align="right"  heigth="300"width="300"><img src="{{asset('images/fotos/'.$pe->archivo)}}" alt="{{ $pe->archivo}}" height="300px" width="300px" class="img-thumbnail"></td>   
               @endforeach
            @break   
                
           </tr>
          
           @endswitch
           @endfor
           @break
        @endswitch   
        
        </table>
        
        </div> 
  
        
       

</form>

    </body>
  
   
    <button type="button" onclick="javascript:imprim1(imp1);">Imprimir</button>
        
</html>
@include('sweetalert::alert')

@push ('scripts')

<script>

function imprim1(imp1){
var printContents = document.getElementById('imp1').innerHTML;
var originalContents = document.body.innerHTML;

document.body.innerHTML = printContents;

window.print();

document.body.innerHTML = originalContents;


}
</script>
@foreach ($ubicacion_mapa as $co)
                
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDVomCQZTYVQSRGPsG6cQPLsoZqYWdZq0w&libraries=places&callback=initAutocomplete"
    async defer></script>
<script type="text/javascript">


var map; //Will contain map object.
var marker = false; ////Has the user plotted their location marker? 

function initAutocomplete() {
  var var_location = new google.maps.LatLng({{$co->latitud}}, {{$co->longitud}});
    var map = new google.maps.Map(document.getElementById('map-container'), {
    center: {lat: {{$co->latitud}}, lng:{{$co->longitud}}},
    zoom: 17,
    mapTypeId: 'roadmap'
  });
  marker = new google.maps.Marker({
              position: var_location,
              map: map,
                draggable: true //make it draggable
              });
        //-----------
        google.maps.event.addListener(map, 'click', function(event) {                
        //Get the location that the user clicked.
        var clickedLocation = event.latLng;
        //If the marker hasn't been added.
        if(marker === false){
            //Create the marker.
           
            
            marker = new google.maps.Marker({
              position: clickedLocation,
              map: map,
                draggable: true //make it draggable
              });
            //Listen for drag events!
            google.maps.event.addListener(marker, 'dragend', function(event){
              markerLocation();
            });
          } else{
            //Marker has already been added, so just change its location.
            marker.setPosition(clickedLocation);
          }
        //Get the marker's location.
        markerLocation();
      });

        //-----------

        // Create the search box and link it to the UI element.
        var input = document.getElementById('pac-input');
        var searchBox = new google.maps.places.SearchBox(input);
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

        // Bias the SearchBox results towards current map's viewport.
        map.addListener('bounds_changed', function() {
          searchBox.setBounds(map.getBounds());
        });

        var markers = [];
        // Listen for the event fired when the user selects a prediction and retrieve
        // more details for that place.
        searchBox.addListener('places_changed', function() {
          var places = searchBox.getPlaces();

          if (places.length == 0) {
            return;
          }

          // Clear out the old markers.
          markers.forEach(function(marker) {
            marker.setMap(null);
          });
          markers = [];

          // For each place, get the icon, name and location.
          var bounds = new google.maps.LatLngBounds();
          places.forEach(function(place) {
            if (!place.geometry) {
              console.log("Returned place contains no geometry");
              return;
            }
            var icon = {
              url: place.icon,
              size: new google.maps.Size(71, 71),
              origin: new google.maps.Point(0, 0),
              anchor: new google.maps.Point(17, 34),
              scaledSize: new google.maps.Size(25, 25)
            };

            // Create a marker for each place.
            markers.push(new google.maps.Marker({
              map: map,
              icon: icon,
              title: place.name,
              position: place.geometry.location
            }));

            if (place.geometry.viewport) {
              // Only geocodes have viewport.
              bounds.union(place.geometry.viewport);
            } else {
              bounds.extend(place.geometry.location);
            }
          });
          map.fitBounds(bounds);
        });
      }

      function markerLocation(){
    //Get location.
    var currentLocation = marker.getPosition();
    //Add lat and lng values to a field that we can save.
    document.getElementById('lat').value = currentLocation.lat(); //latitude
    document.getElementById('lng').value = currentLocation.lng(); //longitude
  }

</script>
                </td> 
              
            @endforeach
@endpush

@endsection
