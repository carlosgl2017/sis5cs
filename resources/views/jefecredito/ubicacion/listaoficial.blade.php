@extends ('layouts.admin3')
@section ('contenido')

<div class="box">
  <div class="box-header">
    <h3>Lista Oficiales</h3>
  </div>
  
</div>
<div class="col-md-3 col-sm-3 col-xs-12 pull-right">
    <a href="{{url('/jefecredito/chart/index')}}" class="btn btn-block btn-social btn-dropbox">
      <i class="fa fa-plus-square"></i>Reporte Estadistico
    </a>
  </div>

  
  <!-- /.box-header -->
  <div class="box-body">
    <table  class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>Nª</th>
          <th>Nombre Oficial</th>
          <th>Acciones</th>
        </tr>
      </thead>
      @foreach($oficial as $of)
      <tbody>
      <td>{{$loop->iteration}}</td>
      <td>{{$of->name}}</td>
      <td><a href="{{url('/jefecredito/visitas/'.$of->id_users.'/reporteubicacion')}}" rel="tooltip" title="Ver Imagenes" class="btn btn-success btn-simple btn-xs">
        <i class="fa fa-eye "></i> 
      </a> </td>
      

     
      </tbody>
      @endforeach
    </table>
  </div>
  <!-- /.box-body -->
</div>

@include('sweetalert::alert')
@push ('scripts')
<script>
  $('#liJefe_marcar').addClass("active");
</script>
@endpush
@endsection