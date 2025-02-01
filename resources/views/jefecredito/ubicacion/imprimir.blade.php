@extends ('layouts.admin3')
@section ('contenido')
<html>
    @switch($tamtiempototal)
     @case(1)
     <div id="imp1">
    <table id="mytable"   border="0" width="100%" cellspacing="0" cellpadding="0" style="border-collapse: collapse;">
      <tr>          
       <td>                     
          <br>
              <small> <em><i style="color:#B73451"; > Creacion Reporte: {{$now}} </i></em> </small> </td>
      </td>
       <td valign="top" align="right"><left><small><em><p style="color:#B73451"; >Cooperativa de Ahorro y Credito Societaria  <br>                                           
              San Martin  R.L.&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;
              </p></em></small></td>
      <td   width="50" heigth="50" valign="top"> <img src="{{asset('images/logo1.png')}}"  height="50px" width="50px" class="img-thumbnail" >     
      </td>            
       </tr> 
        </table>        
                  
  <center><h3>REPORTE DIA DE VISITA</h3></center> 
    <table  border="0"   width="45%">
      <tbody>
        <tr>
        <td><b>Nombre Oficial:</b></td>
        <td>{{$name}}</td>
        </tr>
        
        <tr><td><b>Fecha de Visita:</b></td>
        <td>{{$fecha}}</td>
       </tr>

       <tr><td><b>Numero de Visita:</b></td>
       <td>{{$idvis}}</td>
       </tr>
       
      </tbody>
     
    </table>
    
     <h4><b>Visita 1</b></h4>
         <table border ="0"  width="100%" eight="40%" >
         <th colspan ="1" style="text-align: center"> LOCALIZACION DE LA VISITA</th>
         <tr>
          <td rowspan="7"  id="map-container" WIDTH="80%" HEIGHT="80%"></td>       
         </tr>
       </table>
       
      <table width="100%" border="0">
    
    <th style="text-align: center" colspan="2" class="fondo"> DATOS</th>
    <tr>
        <td ><b>Nombre Socio:</b>    {{$nombre[0][0]}} {{$ap_paterno[0][0]}} {{$ap_materno[0][0]}}</td>
        <td ><b>Hora Inicio:</b>  {{$tiempoinifin[0]}}</td>        
        </tr>
        <tr>
        <td><b>Numero de Credito:</b> {{$id_credito[0][0]}}</td>
        <td><b>Hora Fin:</b> {{$tiempoinifin[1]}}</td>
     
       </tr>
       <tr>
       <td><b>Direccion:</b> {{$direccion[0][0]}}</td>
        <td><b>Tiempo Transcurrido:</b>  {{$horas[0][0]}} :Horas  {{$minutos[0][0]}}:Minutos {{$segundos[0][0]}}:Segundos</td>
       </tr>
    
    </table>
    
    </table>
    <table border="0" width="100%">
    <tr>
      <th colspan ="2" style="text-align: center"> FOTOGRAFIAS</th>
      
      </tr>
      <tr>
    @foreach($datosvisita[0] as $vi)
      <td ><img src="{{asset('images/fotos/'.$vi->archivo)}}" alt="{{ $vi->archivo}}" height="320px" width="320px" class="img-thumbnail">  </td>      
      @endforeach
      </tr>
      <tr>
      @foreach($datosvisita[0] as $vi)
      <td> Fecha de Creacion: {{$vi->created_at}}</td>
      @endforeach
      </tr>
    </table>
    </div> 
    <button type="button" onclick="javascript:imprim1(imp1);">Imprimir</button>
     @break
    @endswitch
</html>


@push ('scripts')
            <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDVomCQZTYVQSRGPsG6cQPLsoZqYWdZq0w"></script>
            <script type="text/javascript">                 
	          window.onload=function init_map() {
              var props = [
              @foreach ($datosvisita[0] as $vi)
              { lat: "{{ $vi->latitud }}", lng: "{{ $vi->longitud }}"},
           
                @endforeach
              ];
              //zoom de visita1
            var var_location = new google.maps.LatLng(props[0].lat ,props[0].lng);
            var var_mapoptions = {
            center: var_location,
            zoom: 18
            };
            
            //posicion del maker de visita 1
            var var_map = new google.maps.Map(document.getElementById("map-container"),
            var_mapoptions);
            
            var latlang = new google.maps.LatLng (props[0].lat, props[0].lng);
      
            var var_marker = new google.maps.Marker({
            position: latlang,
            map: var_map
            
           });             
           var_marker.setMap(var_map);                  
          }
          google.maps.event.addDomListener(window, 'load', init_map);
         
 
     
     

      
</script>

<script>
function imprim1(imp1){
var printContents = document.getElementById('imp1').innerHTML;
var originalContents = document.body.innerHTML;
document.body.innerHTML = printContents;
window.print();
document.body.innerHTML = originalContents;
}
</script>
@endpush 
@endsection
