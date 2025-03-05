<?php

namespace sis5cs\Http\Controllers\Oficial;

use Maatwebsite\Excel\Facades\Excel;
use sis5cs\Imports\VentaComercializacionProductoImport;
use Illuminate\Http\Request;
use Session;
use sis5cs\Http\Controllers\Controller;
use sis5cs\VentaComercializacionProducto;

class VentaComercializacionProductoController extends Controller
{
    // variables

    public function __construct(Excel $excel)
    {
        $this->excel = $excel;
    }

    public function index()
    {
        if (session('id_persona') == null||session('id_credito')==null) {
            alert()->info('Info', 'Seleccione un socio y credito')->showConfirmButton();
            return redirect('oficial/dashboard/');
        } else {
            $venta = VentaComercializacionProducto::where('id_persona', session('id_persona'))->where('id_credito', session('id_credito'))->get();
            return view('oficial.venta_comercializacion_producto.index')->with(compact('venta'));
        }

    }

    public function import(Request $request)
    {
        $this->id_persona = session('id_persona');
        if ($this->id_persona == null) {
            flash()->addWarning('Seleccione un crédito.');
            return redirect('oficial/dashboard/');
        } else {
            $file = $request->file('costo_ventas');
            Excel::import(new VentaComercializacionProductoImport, $file);
            $venta = VentaComercializacionProducto::where('id_persona', $this->id_persona)->get();
            alert()->info('Info', 'Se realizó la carga de datos correctamente')->showConfirmButton();
            return view('oficial.venta_comercializacion_producto.index')->with(compact('venta'));
        }
    }

    public function create()
    {
        if (session('id_persona') == null||session('id_credito')==null) {
            alert()->info('Info', 'Seleccione un socio crédito')->showConfirmButton();
            return redirect('oficial/dashboard/');
        } else {
            $if_exist = VentaComercializacionProducto::where('id_persona', session('id_persona'))->where('id_credito', session('id_credito'))->count();
            if ($if_exist > 100) {
                alert()->info('Info', 'Ya registro los datos de venta y comercializacion.')->showConfirmButton();
                return redirect('oficial/venta_comercializacion_producto/');
            } else {
                return view('oficial.venta_comercializacion_producto.create');
            }
        }

    }

    public function edit($id)
    {
        if (session('id_persona') == null) {
            flash()->addWarning('Seleccione un crédito.');
            return redirect('oficial/dashboard/');
        } else {
            $ventas = VentaComercializacionProducto::find($id);
            return view('oficial.venta_comercializacion_producto.edit')->with(compact('ventas')); //formulario de registro
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
            'porcentaje' => 'numeric|required'
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
        $ven->id_persona = session('id_persona');
        $ven->save(); //metodo se encarga de ejecutar un insert sobre la tabla
        $notification = 'Exelente sus datos  se modificaron correctamente';
        return redirect('oficial/venta_comercializacion_producto/')->with(compact('notification'));
    }

    public function destroy($id)
    {
        $venta = VentaComercializacionProducto::find($id);
        $venta->delete(); //delete
        return back();
    }

    public function download()
    {
        $pathtoFile = public_path() . '/plantillas_excel/template_venta_comercializacion.xlsx';
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
