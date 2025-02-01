@extends ('layouts.admin3')
@section ('contenido')

<div class="box">
  <div class="box-header">
    <h3>Lista de Reportes Visitas</h3>
  </div>


  
  <!-- /.box-header -->
  <div class="box-body">
    <table id="other" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>No</th>
          <th>Fecha de la Vista</th>
          <th>Numero de Visitas</th>
          <th>Acciones</th>
        </tr>
      </thead>
      
      <tbody>
      @foreach($visita as $vi)
      <tr>
      <td>{{$loop->iteration}}</td>
      <td>{{$vi->fecha_visita}}</td>
      <td>{{$vi->total}}</td>
      <td><a href="{{url('/jefecredito/visitas/'.$vi->fecha_visita.'/'.$vi->total.'/'.$iduser.'/report')}}" rel="tooltip" class="btn btn-success btn-simple btn-xs">
        <i class="fa fa-eye "></i> 
      </a> </td>
      </tr>
      @endforeach
      </tbody>
      
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