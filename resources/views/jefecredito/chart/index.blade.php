@extends ('layouts.admin3')
@section ('contenido')

<div class="box">
  <div class="box-header">
    <h3>Seleccione Alguna Opcion</h3>
  </div>


  @if(session('notification'))
  <div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h4><i class="icon fa fa-check"></i> Notificación</h4>
    {{session('notification')}}.
  </div>
  @endif

  <!-- /.box-header --> 
  <form action="{{url('jefecredito/chart/vistareporte/')}}" >
  <div class="box-body">
        <div class="form-group">
          <select class="custom-select" onchange="MostrarFecha(event)" name="id_opcion_estadistica" id="id_opcion_estadistica">
          <option selected>Seleccione Fecha</option>
          <option value="1">Año</option>
          <option value="2">Mes</option>
          <option value="3">Semana</option>
          <option value="4">Dia</option>
         </select> 
         </div>

         <div id="anio">
         <div class="form-group">
           <label for="fecha_visita">Datos por Año </label>
           <input type="number" id="anio" name="anio"  minlength="4" maxlength="4" placeholder="Escriba un Año" >
        </div>
        </div>

        <div id="mes">
        <div class="form-group">
          <label for="fecha_visita">Datos por Mes</label>
          <input type="month" id="start" name="mes" min="2021-01" >
        </div>
        </div>

        <div id="semana">
        <div class="form-group">
     
          <label for="fecha_visita">Datos por Semana </label><br>
          Desde: <input type="date" name="iniciodia"  > 
          A: <input type="date" name="findia"  >
        </div>
        </div>


        <div id="dia">
        <div class="form-group">
          <label for="fecha_visita">Datos por Dia</label>
          <input type="date" name="dia"  >
        </div>
        </div>
      <tbody>
      <div class="form-group">

           <input type="submit" class="btn btn-primary" value="Aceptar">
           </div>
      </tbody>

  </div>
</form>
  <!-- /.box-body -->
</div>
@include('sweetalert::alert')
@push ('scripts')
<script>
  $('#liJefe_marcar').addClass("active");
</script>

<script type="text/javascript">
    
    document.getElementById("anio").style.display = "none";
    document.getElementById("mes").style.display = "none";
    document.getElementById("semana").style.display = "none";
    document.getElementById("dia").style.display = "none";

    function MostrarFecha(event) {
      var opt = $('#id_opcion_estadistica').val();
      if (opt == "1") {
        document.getElementById("anio").style.display = "block";
        document.getElementById("mes").style.display = "none";
        document.getElementById("semana").style.display = "none";
        document.getElementById("dia").style.display = "none";
        //document.getElementById("nombre").innerHTML = "Carpeta de Fotos ANTES";
        //$('#holos').show();
      }else if(opt == "2") {
        document.getElementById("mes").style.display = "block";
        document.getElementById("anio").style.display = "none";
        document.getElementById("semana").style.display = "none";
        document.getElementById("dia").style.display = "none";

      }
      else if(opt == "3") {
        document.getElementById("semana").style.display = "block";
        document.getElementById("mes").style.display = "none";
        document.getElementById("dia").style.display = "none";
        document.getElementById("anio").style.display = "none";
        

      }
      else if(opt == "4") {
        document.getElementById("dia").style.display = "block";
        document.getElementById("mes").style.display = "none";
        document.getElementById("semana").style.display = "none";
        document.getElementById("anio").style.display = "none";

      }

    }
  </script>
@endpush
@endsection



