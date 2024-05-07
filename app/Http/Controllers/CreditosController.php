<?php

namespace App\Http\Controllers;

use App\Models\CaracteristicasProducto;
use App\Models\Producto;
use App\Models\SolServicio;
use Illuminate\Http\Request;

class CreditosController extends Controller
{
    public function show(Request $request)
    {
        // $sol = SolServicio::select(['id', 'clientes_id', 'producto_id', 'estado_solicitud', 'monto', 'tiempo'])->where('clientes_id', $request->id)->get();

        // foreach ($sol as $value) {
        //     $value->producto = CaracteristicasProducto::find($value->producto_id);

        //     if (isset($value->producto)) {
        //         $product = Producto::find($value->producto->productos_id);
        //         $value->producto->nombre_producto = $product->nombre;
        //     }
        // }

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
}
