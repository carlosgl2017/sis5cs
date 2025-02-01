@extends ('layouts.admin3')
@section ('contenido')

<section class="content-header">
  <div class="row">

    <div class="col-md-4 col-sm-4 col-xs-12 pull-right" >
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
  </div><!-- /.row -->


  @if(session('notification'))
  <div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h4><i class="icon fa fa-check"></i> Notificación</h4>
    {{session('notification')}}.
  </div>
  @endif

</section>

@include('sweetalert::alert')
@endsection