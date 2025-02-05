@extends ('layouts.admin3')
@section ('contenido')
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <h3>Vincular persona garante existente al crédito</h3>
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
    </div>
    <form method="post" action="{{url('oficial/garante/vincular')}}">
        {{csrf_field()}}
        <div class="row">

            <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                <div class="form-group">
                    <label for="id_credito"> id crédito</label>
                    <input type="text" name="id_credito" class="form-control" value="{{ session('id_credito')}}" readonly>
                </div>
            </div>

            <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                <div class="form-group">
                    <label for="id_persona"> Titular id</label>
                    <input type="text" name="id_persona" class="form-control" value="{{ session('id_persona')}}" readonly>
                </div>
            </div>

            <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                <div class="form-group" class="form-control">
                    <label for="id_persona_garante"> Selecciona Garante a vincular al crédito</label>
                    <select name="id_persona_garante" class="form-control selectpicker" data-size="5" id="id_persona_garante"
                            data-live-search="true" required>
                        @foreach($personas as $per)
                            <option value="{{$per->id_persona}}"> {{$per->id_persona}}  {{$per->ap_paterno}} {{$per->ap_materno}}  {{$per->nombre}}</option>
                        @endforeach
                    </select>
                </div>
            </div>


            <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                <div class="form-group">
                    <button class="btn btn-primary" type="submit">Guardar</button>
                    <a href="{{url('/oficial/persona')}}" class="btn btn-danger">Cancelar</a>
                </div>
            </div>

        </div>
    </form>

    @push ('scripts')
        <script>
            $('#liC1').addClass("treeview active");
            $('#liPersona').addClass("active");
        </script>
    @endpush
@endsection
