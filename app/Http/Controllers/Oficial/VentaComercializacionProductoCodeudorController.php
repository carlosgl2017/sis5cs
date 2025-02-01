<?php

namespace sis5cs\Http\Controllers\Oficial;

use Maatwebsite\Excel\Facades\Excel;
use sis5cs\Imports\VentaComercializacionProductoCodeudorImport;
use sis5cs\Http\Controllers\Controller;
use Illuminate\Http\Request;
use sis5cs\VentaComercializacionProducto;
use Session;

class VentaComercializacionProductoCodeudorController extends Controller
{
    // variables
    public $numero_filas;

    public function index()
    {
        if (session('id_persona_codeudor') == null) {
            flash()->addWarning('Seleccione un Codeudor');
            return redirect('oficial/codeudor/');
        } else {
            $venta = VentaComercializacionProducto::where('id_persona', session('id_persona_codeudor'))->where('id_credito', session('id_credito'))->get();
            return view('oficial.a_codeudores.venta_comercializacion_producto.index')->with(compact('venta'));
        }
    }

    public function import(Request $request)
    {
        if (session('id_persona_codeudor') == null) {
            flash()->addWarning('Seleccione un Codeudor');
            return redirect('oficial/codeudor/');
        } else {
            $file = $request->file('costo_ventas');
            Excel::import(new VentaComercializacionProductoCodeudorImport, $file);
            $venta = VentaComercializacionProducto::where('id_persona', session('id_persona_codeudor'))->where('id_credito', session('id_credito'))->get();
            flash()->addSuccess('Registro Exitoso', 'Los datos se cargaron correctamente.');
            return redirect('oficial/a_codeudores/venta_comercializacion_producto/');
        }
    }

    public function create()
    {
        if (session('id_persona_codeudor') == null) {
            flash()->addWarning('Seleccione un Codeudor');
            return redirect('oficial/codeudor/');
        } else {
            $if_exist = VentaComercializacionProducto::where('id_persona', session('id_persona_codeudor'))->where('id_credito', session('id_credito'))->count();
            if ($if_exist > 100) {
                flash()->addWarning('Ya registro los datos de venta y comercializacion.');
                return redirect('oficial/a_codeudores/venta_comercializacion_producto/');
            } else {
                return view('oficial.a_codeudores.venta_comercializacion_producto.create');
            }
        }
    }

    public function edit($id)
    {
        if (session('id_persona_codeudor') == null) {
            alert()->info('Info', 'Seleccione un codeudor')->showConfirmButton();
            return redirect('oficial/codeudor/');
        } else {
            $ventas = VentaComercializacionProducto::find($id);
            return view('oficial.a_codeudores.venta_comercializacion_producto.edit')->with(compact('ventas')); //formulario de registro
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
        return redirect('oficial/a_codeudores/venta_comercializacion_producto/');
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
