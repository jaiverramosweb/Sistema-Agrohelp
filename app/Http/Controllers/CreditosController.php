<?php

namespace App\Http\Controllers;

use App\Models\Amortization;
use App\Models\CaracteristicasProducto;
use App\Models\Client;
use App\Models\FacturaPago;
use App\Models\MetodoPago;
use App\Models\PagoAbono;
use App\Models\PagoAmortizacion;
use App\Models\Producto;
use App\Models\SolServicio;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class CreditosController extends Controller
{
    public function show(Request $request)
    {
        $sol = $this->pagination($request);
        return response()->json($sol, 200);
    }

    public $search_;

    public function pagination(Request $request)
    {
        $entries = $request->show;

        $search         = $request->search      == "" ?  "" : $request->search;
        $order_type     = $request->order_type  == "" ? "DESC" : $request->order_type;
        $order_field    = $request->order_field == "" ? "sol_servicios.id" : $request->order_field;

        if ($search == "") {

            $h = SolServicio::select([
                'sol_servicios.id',
                'sol_servicios.clientes_id',
                'sol_servicios.producto_id',
                'sol_servicios.estado_solicitud',
                'sol_servicios.monto',
                'sol_servicios.tiempo',
                'sol_servicios.created_at',
                'clients.nombre',
                'caracteristicas_productos.nombre AS nombre_caract',
                'productos.nombre AS nombre_producto',
            ])
                ->join("clients", "sol_servicios.clientes_id", "clients.id")
                ->join("caracteristicas_productos", "sol_servicios.producto_id", "caracteristicas_productos.id")
                ->join("productos", "caracteristicas_productos.productos_id", "productos.id")
                ->where('clientes_id', $request->id)
                ->orderBy($order_field, $order_type);

            $show = $h->paginate($request->show);
        } else {

            $h = SolServicio::select([
                'sol_servicios.id',
                'sol_servicios.clientes_id',
                'sol_servicios.producto_id',
                'sol_servicios.estado_solicitud',
                'sol_servicios.monto',
                'sol_servicios.tiempo'
            ])
                ->join("clients", "sol_servicios.clientes_id", "clients.id")
                ->where('clientes_id', $request->id)
                ->orderBy($order_field, $order_type);

            $this->search_ = $search;

            $h->where(function ($query) {

                $campos = [
                    "sol_servicios.estado_solicitud",
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
            'data' => $show,
        ];
    }

    public function getComprobante($id)
    {
        $comprobantes = PagoAmortizacion::select([
            'pago_amortizacions.*',
            'factura_pagos.pago',
        ])
        ->where('amortizations_id', $id)
        ->join('factura_pagos', 'pago_amortizacions.factura_pagos_id', 'factura_pagos.id')
        ->get();

        return response()->json($comprobantes, 200);
    }

    public function get($id)
    {
        $creditos = SolServicio::select([
            'sol_servicios.*',
            'caracteristicas_productos.nombre as nombre_linea'
        ])
        ->join('caracteristicas_productos', 'sol_servicios.linea_id', 'caracteristicas_productos.id')
        ->where('clientes_id', $id)
        ->get();

        $creditosList = [];

        if($creditos){
            $creditosList =  $creditos;
            // foreach ($creditos as $credito) {
            //     $amor = Amortization::Where('sol_servicios_id', $credito->id)->where('estado', '!=', 1)->get();
            //     if($amor){
            //         $creditosList = $credito->amortizacion = $amor;
            //     }
            // }
            
        }

        return response()->json($creditosList, 200);
    }

    public function downloadCompro($id)
    {
        $pagoAmor = PagoAmortizacion::find($id);        
        $pagoAmor->pago = FacturaPago::find($pagoAmor->factura_pagos_id);
        $pagoAmor->amortiz = Amortization::find($pagoAmor->amortizations_id);
        $sol = SolServicio::find( $pagoAmor->amortiz->sol_servicios_id);
        $pagoAmor->cliente = Client::select('nombre', 'documento')->find($sol->clientes_id);
        $pagoAmor->metodo = MetodoPago::find($pagoAmor->metodo_pago_id);
        // dd($pagoAmor->metodo);
        return view('pdf.comprobante', compact('pagoAmor'));
        // return PDF::loadView('pdf.comprobante', compact('pagoAmor'))->stream('archivo.pdf');
    }

    public function getCreditos($id)
    {
        $creditos = Amortization::where('sol_servicios_id', $id)->where('estado', '!=', 1)->get();
        return response()->json($creditos, 200);
    }

    public function saveAbono(Request $request)
    {
        $credito = Amortization::where('sol_servicios_id', $request->id)->first();
        Amortization::where('sol_servicios_id', $request->id)->where('estado', '!=', 1)->delete();

        // PagoAmortizacion::create([
        //     'amortizations_id' => $amortization->id,
        //     'factura_pagos_id' => $factura->id,
        //     'metodo_pago_id'   => $request->metodo_pago,
        //     'descripcion_pago' => isset($request->descripcion_pago) ? $request->descripcion_pago : ''
        // ]);

        foreach ($request->tablaAmortizacion as $value) {
            $amortization = new Amortization();
            $amortization->sol_servicios_id = $request->id;
            $amortization->fecha            = $value['fecha'];
            $amortization->cuota_numero     = $value['mes'];
            $amortization->cuota            = $value['cuota'];
            $amortization->interes          = $value['interes'];
            $amortization->interes2         = $value['interes'];
            $amortization->amortizacion     = $value['amortizacion'];
            $amortization->amortizacion2    = $value['amortizacion'];
            $amortization->saldo_pendiente  =  $value['saldoPendiente'];
            $amortization->tasa             = $credito->tasa;
            $amortization->mora             = $credito->mora;
            $amortization->monto_solicitado = $credito->monto_solicitado;
            $amortization->tiempo_pagar     = $credito->tiempo_pagar;
            $amortization->save();
        }

        $factura = FacturaPago::create([
            'pago' => $request->monto,
            'fecha_pagar' => $request->fecha_pagar,
            'sol_servicios_id' =>  $credito->sol_servicios_id,
            'tipo' =>  $request->tipo,
            'metodo_pago_id' =>  $request->metodo_pago,
            'descripcion_pago' => isset($request->descripcion_pago) ? $request->descripcion_pago : ''
        ]);

        PagoAmortizacion::create([
            'amortizations_id' => $credito->id,
            'factura_pagos_id' => $factura->id,
            'metodo_pago_id'   => $request->metodo_pago,
            'descripcion_pago' => isset($request->descripcion_pago) ? $request->descripcion_pago : ''
        ]);

        $pago = new PagoAbono();
        $pago->sol_servicios_id = $request->id;
        $pago->tipo             = $request->tipo;
        $pago->monto            = $request->monto;
        $pago->metodo_pago_id   = $request->metodo_pago;
        $pago->save();

        

        $solicitud = SolServicio::find($request->id);
        $solicitud->valor = strval($request->capital);
        $solicitud->save();

        return response()->json($pago, 201);
    }

    public function getAbono($id)
    {
        $pagos = PagoAbono::select([
            'pago_abonos.*',
            'metodo_pagos.name'
        ])
        ->join('metodo_pagos', 'pago_abonos.metodo_pago_id', 'metodo_pagos.id')
        ->where('sol_servicios_id', $id)        
        ->get();
        return response()->json($pagos, 200);
    }

    public function downloadAbono($id)
    {
        $pago = PagoAbono::find($id);        
        $sol = SolServicio::find( $pago->sol_servicios_id);
        $pago->cliente = Client::select('nombre', 'documento')->find($sol->clientes_id);
        $pago->metodo = MetodoPago::find($pago->metodo_pago_id);
        // dd($pago);
        return view('pdf.abono', compact('pago'));
        // return PDF::loadView('pdf.comprobante', compact('pagoAmor'))->stream('archivo.pdf');
    }
}
