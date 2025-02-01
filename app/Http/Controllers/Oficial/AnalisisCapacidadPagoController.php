<?php

namespace sis5cs\Http\Controllers\Oficial;

use sis5cs\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Session;
use sis5cs\IngresoMensual;
use sis5cs\Credito;
use sis5cs\TipoCredito;
use sis5cs\CapacidadPago;

class AnalisisCapacidadPagoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $id=session('id_persona');
        $idc=session('id_credito');
        if (session('id_persona') == null || session('id_credito') == null) {
            alert()->info('Info', 'Seleccione un Socio y crédito')->showConfirmButton();
            return redirect('oficial/dashboard/');
        } else {
            $ingreso_promedio_prestatario = DB::table('ingreso_mensual')->where('id_persona', $id)->where('id_credito',$idc)->avg('prestatario');
            $ingreso_promedio_conyugue = DB::table('ingreso_mensual')->where('id_persona', $id)->where('id_credito',$idc)->avg('conyugue');
            $ingreso_promedio_otros = DB::table('ingreso_mensual')->where('id_persona', $id)->where('id_credito',$idc)->avg('otros');
            $ingreso_promedio_codeudores = DB::table('ingreso_mensual')->where('id_persona', $id)->where('id_credito',$idc)->avg('codeudores');


            $v_precio_total = DB::table('venta_comercializacion_productos')->where('id_persona', $id)->where('id_credito',$idc)->sum('v_precio_total');
            $c_costo_total = DB::table('venta_comercializacion_productos')->where('id_persona', $id)->where('id_credito',$idc)->sum('c_costo_total');


            $total_mano_obra = DB::table('mano_obra_mensual')->where('id_persona', $id)->where('id_credito',$idc)->sum('total_mano_obra');

            $total_gastos_operativos = DB::table('gastos_operativos_comercializacion')
                ->select(DB::raw('sum(COALESCE(combustible,0)+COALESCE(deposito_almacen,0)+COALESCE(energia_electrica,0)+COALESCE(agua,0)+COALESCE(gas,0)+COALESCE(telefono,0)+COALESCE(impuestos,0)+COALESCE(alquiler,0)+COALESCE(cuidado_sereno,0)+COALESCE(transporte,0)+COALESCE(mantenimiento,0)+COALESCE(publicidad,0)+COALESCE(otros,0))'))
                ->where('id_persona', $id)
                ->where('id_credito', $idc)
                ->get();


            //utilidad operativa
            $utilidad_operativa = ($ingreso_promedio_prestatario + $ingreso_promedio_conyugue + $ingreso_promedio_otros + $ingreso_promedio_codeudores + $v_precio_total) - ($c_costo_total + $total_mano_obra + $total_gastos_operativos[0]->sum);

            $calculo = $utilidad_operativa * $this->capacidadPago($id,$idc);

            $total_cuentas_por_pagar = DB::table('cuentas_por_pagar')->where('id_persona', $id)->where('id_credito',$idc)->sum('cuota_mensual');


            $total_gastos_familiares = DB::table('gastos_familiares')
                ->select(DB::raw('sum(COALESCE(alimentacion,0)+COALESCE(energia_electrica,0)+COALESCE(agua,0)+COALESCE(telefono,0)+COALESCE(gas,0)+COALESCE(impuestos,0)+COALESCE(alquileres,0)+COALESCE(educacion,0)+COALESCE(transporte,0)+COALESCE(salud,0)+COALESCE(empleada,0)+COALESCE(diversion,0)+COALESCE(vestimenta,0)+COALESCE(otros,0))'))
                ->where('id_persona', $id)
                ->where('id_credito', $idc)
                ->get();

            //margen de ahorro
            $total_prestamos = DB::table('prestamo_bancario')->where('id_persona', $id)->where('id_credito',$idc)->sum('importe_ultimo_pago');
            $margen_ahorro = $utilidad_operativa - ($this->amortizacionSanMartin($id,$idc) + $total_prestamos + $total_cuentas_por_pagar + $total_gastos_familiares[0]->sum);

            //CALIFICACION DE SI TIENE CAPACIDAD DE PAGO
            $tiene_capacidad = $this->amortizacionSanMartin($id,$idc) + $total_prestamos;
            //calculo capacidad respuesta
            $tiene = $calculo - $tiene_capacidad;
            $resultado_capacidad = $this->tieneCapacidadPago($tiene);
            $inf_prestamos = DB::table('prestamo_bancario')
                ->join('entidad_bancaria', 'prestamo_bancario.id_entidad_bancaria', '=', 'entidad_bancaria.id_entidad_bancaria')
                ->join('tipo_credito', 'prestamo_bancario.id_tcredito', '=', 'tipo_credito.id_tcredito')
                ->select('prestamo_bancario.*', 'entidad_bancaria.nombre_entidad', 'tipo_credito.tipo_credito')
                ->where('id_persona', $id)
                ->where('id_credito', $idc)
                ->get();

            return view('oficial.analisis_capacidad_pago.index')->with(compact('creditos'))
                ->with('ingreso_promedio_prestatario', round($ingreso_promedio_prestatario * 100) / 100)
                ->with('ingreso_promedio_conyugue', round($ingreso_promedio_conyugue * 100) / 100)
                ->with('ingreso_promedio_otros', round($ingreso_promedio_otros * 100) / 100)
                ->with('ingreso_promedio_codeudores', round($ingreso_promedio_codeudores * 100) / 100)
                ->with('v_precio_total', $v_precio_total)
                ->with('c_costo_total', $c_costo_total)
                ->with('total_mano_obra', $total_mano_obra)
                ->with('total_gastos_operativos', $total_gastos_operativos[0]->sum)
                ->with('utilidad_operativa', round($utilidad_operativa * 100) / 100)
                ->with('tipo_credito', $this->tipoCredito($id,$idc))
                ->with('porcentaje_capacidad_pago', $this->capacidadPago($id,$idc))
                ->with('calculo', round($calculo * 100) / 100)
                ->with('amortizacion_san_martin', $this->amortizacionSanMartin($id,$idc))
                ->with('total_cuentas_por_pagar', round($total_cuentas_por_pagar * 100) / 100)
                ->with('total_gastos_familiares', $total_gastos_familiares[0]->sum)
                ->with('margen_ahorro', round($margen_ahorro * 100) / 100)
                ->with('resultado_capacidad', $resultado_capacidad)
                ->with('inf_prestamos', $inf_prestamos)
                ->with('tiene', $tiene);
        }

    }

    public function tipoCredito($id,$idc)
    {
        $creditos = DB::table('credito')
            ->join('tipo_credito', 'credito.id_tcredito', '=', 'tipo_credito.id_tcredito')
            ->select('credito.*', 'tipo_credito.tipo_credito')
            ->where('id_persona', $id)
            ->where('id_credito', $idc)
            ->get();

        if (!$creditos->isEmpty()) {
            return $creditos[0]->tipo_credito;
        } else {
            return " ";
        }
    }

    public function capacidadPago($id,$idc)
    {
        $capacidad = CapacidadPago::where('id_persona', $id)->where('id_credito', $idc)->exists();
        if ($capacidad) {
            $porcentaje = CapacidadPago::where('id_persona', $id)->where('id_credito', $idc)->firstOrFail()->porcentaje;
            return $porcentaje;
        } else {
            return null;
        }
    }

    public function amortizacionSanMartin($id,$idc)
    {
        $capacidad = CapacidadPago::where('id_persona', $id)->where('id_credito', $idc)->exists();
        if ($capacidad) {
            $amortizacion_coop_san_martin = CapacidadPago::where('id_persona', $id)->where('id_credito', $idc)->firstOrFail()->amortizacion_coop_san_martin;
            return $amortizacion_coop_san_martin;
        } else {
            return 0;
        }
    }

    public function tieneCapacidadPago($a)
    {
        if ($a <= 0) {
            return "NO TIENE CAPACIDAD";
        } else {
            return "TIENE CAPACIDAD DE PAGO";
        }
    }


}
