@extends ('layouts.admin3')
@section ('contenido')
@if(session('notification'))
<div class="alert alert-success">
    {{session('notification')}}
</div>
@endif


<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Datos del Prestamo</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap" border="4">

                <tbody>
                    <tr>
                        <td style="background:#72705B; font-weight: bold; color:white;">Deudor</td>
                        <td>{{$contrato->dnombre}}</td>
                    </tr>
                    <tr>
                        <td style="background:#72705B; font-weight: bold; color:white;">Dirección Deudor</td>
                        <td>{{$contrato->ddireccion}}</td>
                    </tr>
                    @if($contrato->existe==1)
                    <tr>
                        <td style="background:#72705B; font-weight: bold; color:white;">Codeudor</td>
                        <td>{{$contrato->cnombre}}</td>
                    </tr>
                    @endif
                   
                    <tr>
                        <td style="background:#72705B; font-weight: bold; color:white;">Monto del prestamo</td>
                        @if($contrato->moneda=='MN')
                        <td>{{number_format(($contrato->montoprestamo_sus)*6.86, 2,',','.')}}</td>
                        @else
                        <td>{{number_format($contrato->montoprestamo_sus,2,',','.')}}</td>
                        @endif
                    </tr>
                    <tr>
                        <td style="background:#72705B; font-weight: bold; color:white;">Moneda</td>
                        <td>{{$contrato->moneda}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>



<form method="post" action="{{url('oficial/generar-adenda/')}}">
    {{csrf_field()}}
    <div class="row">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <div class="form-group">
                <label for="fechacontrato">Fecha de contrato del crédito</label>
                <input type="date" name="fechacontrato" class="form-control" value="{{old('fechacontrato',$contrato->fechacontrato)}}" required>
            </div>
        </div>

        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <div class="form-group">
                <label for="nnotaria">Número de notaria de Fé Pública</label>
                <input type="number" min="1" name="nnotaria" class="form-control" value="{{$contrato->nnotaria}}" required>
            </div>
        </div>

        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <div class="form-group">
                <label for="nombreaboga">Nombre de abogado</label>
                <input type="text" name="nombreaboga" class="form-control" value="{{$contrato->nombreaboga}}" required>
            </div>
        </div>

        <!--  <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <div class="form-group">
                <label for="mesesampliacion">Número de meses de ampliación</label>
                <input type="number" min="1" name="mesesampliacion" class="form-control" value="{{old('mesesampliacion,mesesampliacion')}}" required>
            </div>
        </div> -->

        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <div class="form-group">
                <label for="mesesampliacion">Número de cuotas adicionales</label>
                <input type="number" min="1" name="cuotasadicionales" class="form-control" value="{{$contrato->cuotasadicionales}}" required>
            </div>
        </div>

        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <div class="form-group">
                <label for="namortizaciones">Número de amortizaciones diferidas</label>
                <input type="number" min="1" name="namortizaciones" class="form-control" value="{{$contrato->namortizaciones}}" required>
            </div>
        </div>

        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <div class="form-group">
                <label for="amortiza2">Número de cuotas prorrateadas</label>
                <input type="number" min="1" name="amortiza2" class="form-control" value="{{$contrato->amortiza2}}" required>
            </div>
        </div>

        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <div class="form-group">
                <label for="montodiferido">Total Monto diferido capital - interés</label>
                <input type="number" step="any" min="1" name="montodiferido" class="form-control" value="{{$contrato->montodiferido}}" required>
            </div>
        </div>

        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <div class="form-group">
                <label for="mesiniciopago">Mes inicio de pago</label>
                <input type="text" name="mesiniciopago" class="form-control" value="{{$contrato->mesiniciopago}}" required>
            </div>
        </div>

        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <div class="form-group">
                <button class="btn btn-primary" type="submit">Guardar</button>
                <a href="{{url('/oficial/generar-adenda')}}" class="btn btn-danger">Cancelar</a>
            </div>
        </div>

    </div>
</form>
@endsection