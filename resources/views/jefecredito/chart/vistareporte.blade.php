@extends ('layouts.admin3')
@section ('contenido')

<div class="box">
  <div class="box-header">
    <h3>GRAFICA ESTADO DE VISITAS </h3>
  </div>
  @if(session('notification'))
  <div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h4><i class="icon fa fa-check"></i> Notificación</h4>
    {{session('notification')}}.
  </div>
  @endif

  <!-- /.box-header --> <html>
  <form action="{{url('jefecredito/chart/vistareporte/')}}" >
  <head> 

    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
     /// google.charts.load('current', {'packages':['corechart']});
     /// google.charts.setOnLoadCallback(drawChart);
     function init(){     
        google.charts.load('current', {packages: ['corechart']}); var interval = setInterval(function() { if ( google.visualization !== undefined && google.visualization.DataTable !== undefined && google.visualization.PieChart !== undefined ){ clearInterval(interval); window.status = 'ready'; drawChart(); } }, 100);
    }
  
      function drawChart() {
        var datos2 = new Array();  
        
        
            
            //console.log({{$visitaanio}})
            var data = google.visualization.arrayToDataTable([
                ['nombre','total'],
                @foreach ($visitaanio as $vi)
                  [ "{{ $vi->name }}", {{ $vi->total }}],
                @endforeach
                
            
            
        ]);
        var data2 = google.visualization.arrayToDataTable([
                ['nombre','total'],
                ['Ivan Jorge Romero Ferrufino',{{$salidas2[0]}}],
                ['Irma Pacheco Marquez',{{$salidas2[1]}}],
                ['Jaime Bravo Cabrera',{{$salidas2[2]}}]
                
            
            
        ]);
        var options = {
          title: 'Grafica Visitas Realizadas en {{$tipofecha}} {{$anio}}    {{$anio2}}',
          colors: ['#36A2EB','#FF3784','#f0e813','#36A2EB'],
          is3D: true
        };

        var options2 = {
          title: 'Grafica Salidas Realizadas en {{$tipofecha}} {{$anio}}    {{$anio2}}',
          colors: ['#36A2EB','#FF3784','#f0e813','#36A2EB'],
          is3D: true
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));
        var chart2 = new google.visualization.PieChart(document.getElementById('piechart2'));

        chart.draw(data, options);
        chart2.draw(data2, options2);
      }
    </script>
  </head>
  <body onload="init()">
    <div id="piechart" style="width: 900px; height: 500px;"></div>
    <div id="piechart2" style="width: 900px; height: 500px;"></div>
    
    <div><center>TOTAL VISITAS: {{$visitaaniototal}}</div> 
    <div><center>TOTAL SALIDAS: {{$totalsalidas}}</div> 
    <div><a href="{{url('jefecredito/chart/'.$id.'/'.$anio.'/'.$anio2.'/reporte')}}" class="btn btn-primary">Descargar Reporte</a>  </div>
  </body>
  </form>
</html>




  <!-- /.box-body -->
</div>
@include('sweetalert::alert')
@push ('scripts')
<script>
  $('#liJefe_marcar').addClass("active");
</script>

  
@endpush
@endsection



