@extends ('layouts.admin3')
@section ('contenido')
<div class="row">
  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
    <h3>Programar visita</h3>
    @if (count($errors)>0)
    <div class="alert alert-danger">
      <ul>
        @foreach ($errors->all() as $error)
        <li>{{$error}}</li>
        @endforeach
      </ul>
    </div>
    @endif
  </div>

  <div class="col-md-4 col-sm-4 col-xs-12 pull-right">
    <div class="info-box bg-yellow">
      <span class="info-box-icon"><i class="fa fa-user-circle-o"></i></span>
      <div class="info-box-content">
        <span class="info-box-text"> Socio seleccionado:</span>
        <span class="info-box-number">{{session('id_persona_oficial','Usuario no seleccionado')}}</span>
        <div class="progress">
          <div class="progress-bar" style="width: 70%"></div>
        </div>
        <span class="progress-description">
          Crédito: {{session('id_credito','Crédito no seleccionado')}}
        </span>
      </div><!-- /.info-box-content -->
    </div><!-- /.info-box -->
  </div><!-- /.col -->
</div>

<form method="post" action="{{url('oficial/visitas')}}">
  {{csrf_field()}}
  <div class="row">

    <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
      <div class="form-group">
        <label for="fecha_visita">Fecha Visita</label>
        <input type="date" name="fecha_visita" class="form-control" value="{{old('fecha_visita')}}">
      </div>
    </div>

    <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
      <div class="form-group">
        <label for="hora_visita">Hora visita</label>
        <input type="time" name="hora_visita" class="form-control" value="{{old('hora_visita')}}">
      </div>
    </div>


    <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
      <div class="form-group">
        <label for="duracion_minutos">Duración (minutos)</label>
        <input type="integer" mint="0" name="duracion_minutos" class="form-control" value="{{old('duracion_minutos')}}">
      </div>
    </div>

    <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
      <div class="form-group">
        <label for="direccion">Dirección</label>
        <input type="text" name="direccion" class="form-control" value="{{old('direccion')}}">
      </div>
    </div>

    <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
      <div class="form-group">
        <label for="departamento">Departamento</label>
        <input type="text" name="departamento" class="form-control" value="{{old('departamento')}}">
      </div>
    </div>


    <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
      <div class="form-group">
        <label for="ciudad">Ciudad</label>
        <input type="text" name="ciudad" class="form-control" value="{{old('ciudad')}}">
      </div>
    </div>

    <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
      <div class="form-group">
        <label for="provincia">Provincia</label>
        <input type="text" name="provincia" class="form-control" value="{{old('provincia')}}">
      </div>
    </div>

    <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
      <div class="form-group">
        <label for="localidad">Localidad</label>
        <input type="text" name="localidad" class="form-control" value="{{old('localidad')}}">
      </div>
    </div> 

    <div class="row">
     <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <div  id="map-container"></div>
     </div>
   </div>
   <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
      <div class="form-group">
        <label for="latitud">Latitud</label>
        <input type="text" id="lat" name="latitud" readonly="yes">
      </div>
    </div>

    <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
      <div class="form-group">
        <label for="longitud">Longitud</label>
        <input type="text" id="lng" name="longitud" readonly="yes">    
      </div>
    </div>
    <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
      <div class="form-group">
        <button class="btn btn-primary" type="submit">Guardar</button>
        <a href="{{url('/oficial/visitas')}}" class="btn btn-danger">Cancelar</a>
      </div>
    </div>

    
  </div>
</form>
@push ('scripts')
<script>
  $('#liSeguimiento').addClass("treeview active");
  $('#liSeguimiento_visitas').addClass("active");
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDVomCQZTYVQSRGPsG6cQPLsoZqYWdZq0w&libraries=places&callback=initAutocomplete"
    async defer></script>
<script type="text/javascript">


var map; //Will contain map object.
var marker = false; ////Has the user plotted their location marker? 

function initAutocomplete() {
    var map = new google.maps.Map(document.getElementById('map-container'), {
    center: {lat: -19.5892421, lng: -65.7539573},
    zoom: 17,
    mapTypeId: 'roadmap'
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
@endpush
@endsection