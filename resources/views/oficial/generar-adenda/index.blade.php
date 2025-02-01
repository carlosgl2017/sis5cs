@extends ('layouts.admin3')
@section ('contenido')
<div class="box-header">
    <h4 style="text-align: center;">Registrar Contrato de Adenda
    </h4>
</div>


@if(session('notification'))
<div class="alert alert-success">
 {{session('notification')}}
</div>
@endif

<div class="box-body">

    <form method="post" action="{{url('oficial/generar-adenda/verificar')}}">
        {{csrf_field()}}
        <div class="row">


            <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12 alert alert-success" style="background-image: linear-gradient(to top, #09203f 0%, #537895 100%); color:#FFFFFF;font-weight:bold;" role="alert">
                Verificar datos
            </div>


            <div class="row col-md-12 col-md-offset-3">
                <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                    <div class="form-group">
                        <label for="nroprestamo">Número de Préstamo</label>
                        <input type="number" name="nroprestamo" class="form-control" value="{{old('nroprestamo')}}" required>
                    </div>
                </div>
            </div>
            <div class="row col-md-12 col-md-offset-3">
                <div class="col-md-12 col-md-offset-3">
                    <div class="form-group">
                        <button class="btn btn-success btn-lg" type="submit">Verificar</button>
                    </div>
                </div>
            </div>

        </div>
    </form>


</div>

@include('sweetalert::alert')
@endsection


@push('css')
<style>
    .formulario__btn {
        height: 45px;
        line-height: 45px;
        width: 30%;
        background: linear-gradient(to top, #09203f 0%, #537895 100%);
        color: #fff;
        font-weight: bold;
        border: none;
        border-radius: 3px;
        cursor: pointer;
        transition: .1s ease all;
    }
</style>
@endpush