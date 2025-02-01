@extends ('layouts.admin3')
@section ('contenido')
<div class="row">
    <div class="col-md-3 col-sm-6 col-xs-12" style="float:right;">
        <div class="info-box bg-green">
            <span class="info-box-icon"><i class="fa fa-user"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">S. Seleccionado</span>
                <span class="info-box-number"> </span>

                <div class="progress">
                    <div class="progress-bar" style="width: 100%"></div>
                </div>
                <span class="progress-description">
                    {{session('id_persona_oficial','Usuario no seleccionado')}}
                </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
</div>


<!-- Horizontal Form -->
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Editar Fecha de Inicio</h3>
    </div>

    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
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
    <!-- /.box-header -->
    <!-- form start -->
    <form class="form-horizontal" method="post" action="{{url('/jefecredito/seguimiento/'.$seguimiento->id_seguimiento.'/modificar')}}">
        {{csrf_field()}}
        <div class="box-body">
            <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Fecha de inicio</label>
                    <div class="col-sm-10">
                        <input type="datetime-local" name="fecha_inicio" class="form-control" value="{{old('fecha_inicio',$seguimiento->fecha_inicio)}}" required>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.box-body -->
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <div class="form-group">
                <button class="btn btn-primary" type="submit">Guardar</button>
                <a href="{{url('/jefecredito/seguimiento')}}" class="btn btn-default"> cancelar</a>
                <button class="btn btn-danger" type="reset">Restablecer</button>
            </div>
        </div>
        <!-- /.box-footer -->
    </form>
</div>
<!-- /.box -->

@push ('scripts')
<script>
    $('#liC3').addClass("treeview active");
    $('#liGastosFamiliares').addClass("active");
</script>
@endpush
@endsection