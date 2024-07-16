<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Amortization;
use App\Models\CaracteristicasProducto;
use App\Models\Client;
use App\Models\FacturaPago;
use App\Models\MetodoPago;
use App\Models\PagoAmortizacion;
use App\Models\SolServicio;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Barryvdh\DomPDF\Facade\Pdf;

class PagoController extends Controller
{
    public function index(Request $request)
    {
        if (!hasPermissionModule('pago', 'read', 'pago')) {
            return to_route('dashboard');
        }

        $permissions = permissionModule('pago', '', true);

        return Inertia::render('Pagos/Pagar', [
            'permissions' => $permissions
        ]);
    }

    public function indexList(Request $request)
    {
        if (!hasPermissionModule('pago', 'read', 'pago')) {
            return to_route('dashboard');
        }

        $permissions = permissionModule('pago', '', true);
        $pago = $this->pagination($request);

        return Inertia::render('Pagos/Index', [
            'permissions' => $permissions,
            'pago' => $pago,
        ]);
    }

    public $search_;

    public function pagination(Request $request, $pag = 25)
    {
        $entries = $pag;

        if ($request->show) $entries =  $request->show;

        $search         = $request->search      == "" ?  "" : $request->search;
        $order_type     = $request->order_type  == "" ? "DESC" : $request->order_type;
        $order_field    = $request->order_field == "" ? "id" : $request->order_field;

        if ($search == "") {
            $h = FacturaPago::select([
                "factura_pagos.*",
                "sol_servicios.clientes_id",
                "clients.nombre as nombre_cliente",
            ]);

            $h->join('sol_servicios', 'factura_pagos.sol_servicios_id', 'sol_servicios.id')
            ->join('clients', 'sol_servicios.clientes_id', 'clients.id')     
            ->orderBy('factura_pagos.' . $order_field, $order_type);
            $show = $h->paginate($entries);
        } else {

            $h = FacturaPago::select([
                "factura_pagos.*",
            ]);

            $this->search_ = $search;

            $h->where(function ($query) {

                $campos = [
                    "factura_pagos.pago",
                    "factura_pagos.fecha_pagar",
                ];

                for ($i = 0; $i < count($campos); $i++) {
                    $query->orWhere($campos[$i], "ilike", "%" . $this->search_ . "%");
                }
            });
            $show = $h->paginate($entries);
        }

        return [
            'pagination' => [
                'total'         => $show->total(),
                'current_page'  => $show->currentPage(),
                'per_page'      => $show->perPage(),
                'last_page'     => $show->lastPage(),
                'from'          => $show->firstItem(),
                'to'            => $show->lastPage()
            ],
            'data' => $show
        ];
    }

    public function infoPago($id)
    {
        $pagos = PagoAmortizacion::where('factura_pagos_id', $id)->get();

        foreach ($pagos as $pago) {
            $factura = FacturaPago::select('id', 'sol_servicios_id')->where('id', $pago->factura_pagos_id)->first();
            $solservicio = SolServicio::select('id', 'linea_id')->where('id', $factura->sol_servicios_id)->first();
            $pago->credito = CaracteristicasProducto::select('id', 'nombre')->where('id', $solservicio->linea_id)->first();
        }

        return response()->json($pagos, 200);
    }

    public function downloadPago($id)
    {
        $pagoAmor = FacturaPago::find($id);
        $pagoAmor->pago_amortiz = PagoAmortizacion::where('factura_pagos_id', $id)->get();
        // dd($pagoAmor->pago_amortiz);

        $isTable = false;
        
        foreach ($pagoAmor->pago_amortiz as $pago) {

            if($pago->amortizations_id !== 0){
                $pago->amortizacion = Amortization::find($pago->amortizations_id);
                $solservicio = SolServicio::select('id', 'linea_id')->where('id', $pago->amortizacion->sol_servicios_id)->first();
                $pago->credito = CaracteristicasProducto::select('id', 'nombre')->where('id', $solservicio->linea_id)->first();
                $isTable = true;
            } else {
                $solservicio = SolServicio::select('id', 'linea_id')->where('id', $pagoAmor->sol_servicios_id)->first();
                $pago->credito = CaracteristicasProducto::select('id', 'nombre')->where('id', $solservicio->linea_id)->first();
            }

        }

        // $pagoAmor->amortiz = Amortization::find($pagoAmor->amortizations_id);
        $sol = SolServicio::find( $pagoAmor->sol_servicios_id);
        $pagoAmor->cliente = Client::select('nombre', 'documento')->find($sol->clientes_id);
        $pagoAmor->metodo = MetodoPago::find($pagoAmor->metodo_pago_id);
        if($isTable == false){
            $pagoAmor->tipo_credito = CaracteristicasProducto::select('id', 'nombre')->where('id', $sol->linea_id)->first();
        }
        $pagoAmor->is_table = $isTable;

        // dd($pagoAmor);

        return view('pdf.comprobantePago', compact('pagoAmor'));
        // return PDF::loadView('pdf.comprobante', compact('pagoAmor'))->stream('archivo.pdf');
    }
}
