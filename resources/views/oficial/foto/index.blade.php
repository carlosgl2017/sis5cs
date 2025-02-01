@extends ('layouts.admin3')
@section ('contenido')
<div class="row">
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
<!-- div usuario seleccionado-->
</div>

<div class="box-header">

  <h3> Crédito de Seguimiento: {{$idfoto}} </h3>

  @if(session('notification'))
  <div class="alert alert-success">
    {{session('notification')}}
  </div>
  @endif

  <form method="" enctype="multipart/form-data">

    <!-- /.box-header -->
    <div class="container">
      <div style="width: 92%">
        <div class="row">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h4>Seleccione....</h4>
            </div>
            <div class="panel-body">


              <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                <div class="form-group">
                 <label for="tipo">Tipo Reporte</label>
                  <div style="width: 100%">
                    <select onchange="MostrarAutos(event)" name="id_opcion_pdf" class="form-control selectpicker" data-size="5" id="id_opcion_pdf" data-live-search="true">
                      
                      <option value="1"> Reporte de Fotografias  </option>
                      <option value="2">Reporte de Croquis </option>
                      <option value="3"> Reporte Antes y Despues  </option>
                    </select>


                  </div>
                </div>


              </div>

              <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                <div class="form-group">
                  <label for="ci" id="nombre">Carpeta de Fotos</label>
                  <select required name="id_opcion_carpeta" class="form-control selectpicker" data-size="5" id="id_opcion_carpeta" data-live-search="true" >
                </div>
                
                @foreach ($seguimientofoto as $ca)
                <option value="{{$ca->id_seguimiento_foto}}">{{$ca->descripcion}}</option>
                @endforeach
                </select>
              </div>
            </div>

            <div id="midiv">
              <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                <div class="form-group">
                  <label for="ci" >Carpeta de Fotos DESPUES</label>
                  <select required name="id_opcion_carpeta2" class="form-control selectpicker" data-size="5" id="aa" data-live-search="true">
                </div>
                
                @foreach ($seguimientofoto as $ca)
                <option value="{{$ca->id_seguimiento_foto}}">{{$ca->descripcion}}</option>
                @endforeach
                </select>
              </div>
            </div>
          </div>
          <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
          <br>
            <div class="form-group">

              <input type="submit" class="btn btn-primary" value="Ingresar">
            </div>
          </div>
        </div>





  </form>
  <!-- /.box-body -->
  @include('sweetalert::alert')
  @push ('scripts')
  <script>
    $('#liSeguimiento').addClass("treeview active");
    $('#liSeguimiento_reporte').addClass("active");
  </script>
  <script type="text/javascript">
    //$('#id_opcion_pdf').change(function(){
    //$('#id_opcion_carpeta2').removeAttr('disabled');
    //});
    //$('#holos').hide();
    //con esto se oculta el select de antes y despues
    document.getElementById("midiv").style.display = "none";

    function MostrarAutos(event) {
      var opt = $('#id_opcion_pdf').val();
      if (opt == "3") {
        document.getElementById("midiv").style.display = "block";
        document.getElementById("nombre").innerHTML = "Carpeta de Fotos ANTES";
        //$('#holos').show();
      } else {
        document.getElementById("midiv").style.display = "none";
        document.getElementById("nombre").innerHTML = "Carpeta de Fotos ";

      }

    }
  </script>
  @endpush
  @endsection