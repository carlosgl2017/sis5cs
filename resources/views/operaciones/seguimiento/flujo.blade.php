@extends ('layouts.admin3')
@section ('contenido')
<!-- div usuario seleccionado-->
<div class="box-body">

    <div class="col-md-5 col-sm-4 col-xs-12 pull-right" >
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
@if(session('notification'))
<div class="alert alert-success">
    {{session('notification')}}
</div>
@endif
<!-- /.box-header -->
<div class="box-body">      
    <div class="row" style="text-align: center;">
        <h3>Flujo de trámite</h3>
    </div>
    <div class="col-md-2 col-md-offset-5">
        <div id="canvas"></div>
    </div>
</div>
<!-- /.box-body -->
@push ('scripts')
<script>
    window.onload = function() {
        var btn = document.getElementById("run"),
            cd = document.getElementById("code"),
            chart;
        var code =
            `st=>start: Inicio
          e=>end: Fin
          op1=>operation: OFICIAL-DE-CREDITO 
          FECHA-DE-RECEPCION:12-12-2020
          RESPONSABLE:{{strtr(Auth::user()->name, " ", "-")}}
          FECHA-DE-ENTREGA:12-12-2020
          op2=>operation: JEFE-DE-CRÉDITOS FECHA-DE-RECEPCION:12-12-2020
          FECHA-DE-ENTREGA:12-12-2020
          op3=>operation: ENCARGADO-DE-RIESGOS FECHA-DE-RECEPCION:12-12-2020
          FECHA-DE-ENTREGA:12-12-2020
          op4=>operation: ENCARGADO-DE-OPERACIONES FECHA-DE-RECEPCION:12-12-2020
          FECHA-DE-ENTREGA:12-12-2020
          st->op1
          op1->op2
          op2->op3
          op3->op4
          op4->e`;

        (onload = function() {
            if (chart) {
                chart.clean();
            }

            chart = flowchart.parse(code);
            chart.drawSVG('canvas', {
                // 'x': 10,
                // 'y': 10,
                'line-width': 3,
                'maxWidth': 3, //ensures the flowcharts fits within a certian width
                'line-length': 10,
                'text-margin': 10,
                'font-size': 12,
                'font': 'normal',
                'font-family': 'Helvetica',
                'font-weight': 'normal',
                'font-color': 'black',
                'line-color': 'black',
                'element-color': 'black',
                'fill': 'white',
                'yes-text': 'yes',
                'no-text': 'no',
                'arrow-end': 'block',
                'scale': 1,
                'symbols': {
                    'start': {
                        'font-color': 'black',
                        'element-color': 'black',
                        'fill': 'white'
                    },
                    'end': {
                        'class': 'end-element'
                    }
                },
                'flowstate': {
                    'past': {
                        'fill': '#CCCCCC',
                        'font-size': 12
                    },
                    'current': {
                        'fill': 'white',
                        'font-color': 'red',
                        'font-weight': 'bold'
                    },
                    'future': {
                        'fill': '#FFFF99'
                    },
                    'request': {
                        'fill': 'blue'
                    },
                    'invalid': {
                        'fill': '#444444'
                    },
                    'approved': {
                        'fill': '#58C4A3',
                        'font-size': 12,
                        'yes-text': 'APPROVED',
                        'no-text': 'n/a'
                    },
                    'rejected': {
                        'fill': '#C45879',
                        'font-size': 12,
                        'yes-text': 'n/a',
                        'no-text': 'REJECTED'
                    }
                }
            });

            $('[id^=sub1]').click(function() {
                alert('info here');
            });
        })();

    };

    function myFunction(event, node) {
        console.log("You just clicked this node:", node);
    }
</script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/raphael/2.3.0/raphael.min.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="http://flowchart.js.org/flowchart-latest.js"></script>
<script>
    $('#liCodeudor').addClass("treeview active");
    $('#liCodeudor_sub_maquinaria').addClass("active");
</script>
@endpush
@push ('style')
<style type="text/css">
    .end-element {
        fill: #97fa03;
    }
</style>
@endpush
@include('sweetalert::alert')
@endsection