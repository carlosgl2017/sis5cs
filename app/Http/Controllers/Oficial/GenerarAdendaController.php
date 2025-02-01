<?php

namespace sis5cs\Http\Controllers\Oficial;

use sis5cs\Http\Controllers\Controller;
use Illuminate\Http\Request;
use sis5cs\GenerarAdendaContrato;
use PDF2;
use Session;
use Carbon\Carbon;
use \NumerosEnLetras;

class GenerarAdendaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        return view('oficial.generar-adenda.index');
    }

    public function verificar(Request $request)
    {
        $existsprestamo = GenerarAdendaContrato::where('nroprestamo', $request->input('nroprestamo'))->exists();
        if (!$existsprestamo) {
            alert()->info('Info', 'No se ha encontrado prestamo')->showConfirmButton();
            return redirect('oficial/generar-adenda/');
        } else {
            Session::put('nroprestamo', $request->input('nroprestamo'));
            $notification = 'Exelente se ha seleccionado el prestamo correctamente';
            $contrato = GenerarAdendaContrato::find($request->input('nroprestamo'));          

            return view('oficial.generar-adenda.edit')->with(compact('contrato'));
        }
    }

    public function store(Request $request)
    {
        $pres = GenerarAdendaContrato::find(session('nroprestamo'));
        $pres->fechacontrato = $request->input('fechacontrato');
        $pres->nnotaria = $request->input('nnotaria');
        $pres->nombreaboga = $request->input('nombreaboga');
        $pres->cuotasadicionales = $request->input('cuotasadicionales');
        $pres->namortizaciones = $request->input('namortizaciones');
        $pres->montodiferido = $request->input('montodiferido');
        $pres->mesiniciopago = $request->input('mesiniciopago');
        $pres->amortiza2 = $request->input('amortiza2');
        $pres->usuariomodified = auth()->user()->name;
        $pres->save(); //metodo se encarga de ejecutar un insert sobre la tabla
        $notification = 'Exelente se ha guardado';
        return redirect('oficial/generar-adenda/generar/')->with(compact('notification'));
    }
    /*--documento*/
    public function contrato(Request $request)
    {
        $fecha = new Carbon($request->input('fecha'));
        $prestatario = GenerarAdendaContrato::where('nroprestamo', session('nroprestamo'))->firstOrFail();
        $fecha_contrato = new Carbon($prestatario->fechacontrato);
        /* literal */
        if($prestatario->moneda=='MN') {
            $literal= NumerosEnLetras::convertir($prestatario->montoprestamo_bs,'Bs.',true);
        } else{
            $literal= NumerosEnLetras::convertir($prestatario->montoprestamo_sus,'$us.',true);
        }
        /* literal */
        $pdf = PDF2::loadView('oficial.generar-adenda.contrato', ['prestatario' => $prestatario, 'fecha' => $fecha, 'fecha_contrato' => $fecha_contrato,'literal'=>$literal]);
        $pdf->setPaper('folio');
        return $pdf->download();
    }
    public function generar()
    {
        return view('oficial.generar-adenda.generar');
    }
}
