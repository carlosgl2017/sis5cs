<?php

namespace sis5cs\Http\Controllers\Oficial;

use Maatwebsite\Excel\Facades\Excel;
use sis5cs\Imports\VentaComercializacionProductoGaranteImport;
use Illuminate\Http\Request;
use Session;
use sis5cs\Http\Controllers\Controller;
use sis5cs\VentaComercializacionProducto;

class VentaComercializacionProductoGaranteController extends Controller
{
    // variables
    public $numero_filas;

    public function index()
    {

        if (session('id_persona_garante') == null) {
            flash()->addWarning('Seleccione un garante');
            return redirect('oficial/dashboard/');
        } else {
            $venta = VentaComercializacionProducto::where('id_persona', session('id_persona_garante'))->where('id_credito', session('id_credito'))->get();
            return view('oficial.a_garantes.venta_comercializacion_producto.index')->with(compact('venta'));
        }

    }

    public function import(Request $request)
    {
        if (session('id_persona_garante') == null) {
            alert()->info('Info', 'Seleccione al garante')->showConfirmButton();
            return redirect('oficial/garante/');
        } else {
            $file = $request->file('costo_ventas');
            Excel::import(new VentaComercializacionProductoGaranteImport, $file);
            $venta = VentaComercializacionProducto::where('id_persona', session('id_persona_garante'))->where('id_credito', session('id_credito'))->get();
            flash()->addSuccess('Registro Exitoso', 'Los registros se han cargado correctamente');
            return redirect('oficial/a_garantes/venta_comercializacion_producto/');
        }

    }

    public function create()
    {


        if (session('id_persona_garante') == null) {
            flash()->addWarning('seleccione un garante');
            return redirect('oficial/garante/');
        } else {
            $if_exist = VentaComercializacionProducto::where('id_persona', session('id_persona_garante'))->where('id_credito', session('id_credito'))->count();
            if ($if_exist > 100) {
                flash()->addWarning('Ya se han cargado los registros');
                return redirect('oficial/a_garantes/venta_comercializacion_producto/');
            } else {
                return view('oficial.a_garantes.venta_comercializacion_producto.create');
            }
        }
    }

    public function edit($id)
    {
        if (session('id_persona_garante') == null) {
            alert()->info('Info', 'Seleccione un garante')->showConfirmButton();
            return redirect('oficial/garante/');
        } else {
            $ventas = VentaComercializacionProducto::find($id);
            return view('oficial.a_garantes.venta_comercializacion_producto.edit')->with(compact('ventas')); //formulario de registro
        }
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'producto' => 'string|required',
            'cantidad' => 'numeric|required',
            'unidad_medida' => 'string|required',
            'c_costo_unitario' => 'numeric|required',
            'c_costo_total' => 'numeric|required',
            'v_precio_unitario' => 'numeric|required',
            'v_precio_total' => 'numeric|required',
            'utilidad' => 'numeric|required',
            'porcentaje' => 'numeric|required',
        ]);
        $ven = VentaComercializacionProducto::find($id);
        $ven->producto = $request->input('producto');
        $ven->cantidad = $request->input('cantidad');
        $ven->unidad_medida = $request->input('unidad_medida');
        $ven->c_costo_unitario = $request->input('c_costo_unitario');
        $ven->c_costo_total = $request->input('c_costo_total');
        $ven->v_precio_unitario = $request->input('v_precio_unitario');
        $ven->v_precio_total = $request->input('v_precio_total');
        $ven->utilidad = $request->input('utilidad');
        $ven->porcentaje = $request->input('porcentaje');
        $ven->id_persona = $request->input('id_persona');
        $ven->id_credito = $request->input('id_credito');
        $ven->save(); //metodo se encarga de ejecutar un insert sobre la tabla
        flash()->addSuccess('Registro Exitoso', 'El registro ha sido guardado correctamente');
        return redirect('oficial/a_garantes/venta_comercializacion_producto/');
    }

    public function destroy($id)
    {
        $venta = VentaComercializacionProducto::find($id);
        $venta->delete(); //delete
        return back();
    }

    public function download()
    {
        $pathtoFile = public_path() . '/plantillas_excel/venta_comercializacion.xls';
        return response()->download($pathtoFile);
    }

    public function download_transporte()
    {
        $pathtoFile = public_path() . '/plantillas_excel/venta_transporte.xls';
        return response()->download($pathtoFile);
    }

    public function download_comercio()
    {
        $pathtoFile = public_path() . '/plantillas_excel/comercio.xls';
        return response()->download($pathtoFile);
    }
}
