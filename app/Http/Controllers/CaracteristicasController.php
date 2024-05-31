<?php

namespace App\Http\Controllers;

use App\Http\Requests\CaracteristicasRequest;
use App\Models\CaracteristicasDocumentacion;
use App\Models\CaracteristicasGarantia;
use App\Models\CaracteristicasProducto;
use App\Models\Producto;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CaracteristicasController extends Controller
{
    public function index()
    {
        $caracterisicas = CaracteristicasProducto::all();

        return response()->json([
            'status' => true,
            'data' => $caracterisicas
        ], 200);
    }

    public $search_;

    public function pagination(Request $request, $pag = 25)
    {
        $entries = $pag;

        if ($request->show) $entries =  $request->show;

        $search         = $request->search      == "" ?  "" : $request->search;
        $order_type     = $request->order_type  == "" ? "ASC" : $request->order_type;
        $order_field    = $request->order_field == "" ? "id" : $request->order_field;

        if ($search == "") {
            $h = CaracteristicasProducto::select([
                "caracteristicas_productos.*",
                "productos.nombre as producto",
            ]);

            $h->join('productos', 'caracteristicas_productos.productos_id', 'productos.id');
            $h->orderBy('caracteristicas_productos.' . $order_field, $order_type);
            $show = $h->paginate($entries);
        } else {

            $h = CaracteristicasProducto::select([
                "caracteristicas_productos.*",
                "productos.nombre as producto",
            ]);

            $h->join('productos', 'caracteristicas_productos.productos_id', 'productos.id');

            $this->search_ = $search;

            $h->where(function ($query) {

                $campos = [
                    ".caracteristicas_productosnombre"
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

    public function caracteristicas($id)
    {
        $carac = CaracteristicasProducto::select(['id', 'nombre'])->where('productos_id', $id)->get();
        return response()->json([
            'status' => true,
            'data' => $carac
        ], 200);
    }

    public function getCaracteristica($id)
    {
        $carac = CaracteristicasProducto::find($id);
        return response()->json([
            'data' => $carac
        ], 200);
    }

    public function getProductGarantias()
    {
        $products = CaracteristicasProducto::all();

        foreach ($products as $value) {

            $producto = Producto::select(['nombre'])->where('id', $value->productos_id)->first();
            $value->producto = $producto->nombre;

            $value->garantias = CaracteristicasGarantia::select([
                'garantias.nombre',
            ])
                ->join('garantias', 'caracteristicas_garantias.garantias_id', 'garantias.id')
                ->where('caracteristicas_garantias.caracteristicas_productos_id', $value->id)
                ->get();

            $value->documentos = CaracteristicasDocumentacion::select([
                'documentacions.nombre',
            ])
                ->join('documentacions', 'caracteristicas_documentacions.documentacions_id', 'documentacions.id')
                ->where('caracteristicas_documentacions.caracteristicas_productos_id', $value->id)
                ->get();
        }

        return response()->json($products, 200);
    }

    public function saveCaracteristica(CaracteristicasRequest $request)
    {
        $carac = new CaracteristicasProducto();

        $carac->productos_id            = $request->productos_id;
        $carac->nombre                  = $request->nombre;
        $carac->interes                 = $request->interes;
        $carac->mora                    = $request->mora;
        $carac->codigo                  = $request->codigo;
        // $carac->monto_minimo            = $request->monto_minimo;
        $carac->monto_maximo            = $request->monto_maximo;
        // $carac->tiempo_minimo           = $request->tiempo_minimo;
        $carac->tiempo_maximo           = $request->tiempo_maximo;
        $carac->tipo_amortizacion       = $request->tipo_amortizacion;
        $carac->terminos_condiciones    = $request->terminos_condiciones;
        $carac->cobro_intereses         = $request->cobro_intereses;
        $carac->periodicidad            = $request->periodicidad;
        $carac->indicador               = 'En espera';

        $carac->save();

        if (isset($request->garantias)) {
            foreach ($request->garantias as $garantia) {
                CaracteristicasGarantia::create([
                    'caracteristicas_productos_id'  => $carac->id,
                    'garantias_id'                  => $garantia['id']
                ]);
            }
        }

        if (isset($request->documentos)) {
            foreach ($request->documentos as $documento) {
                CaracteristicasDocumentacion::create([
                    'caracteristicas_productos_id'  => $carac->id,
                    'documentacions_id'             => $documento['id']
                ]);
            }
        }

        return response()->json([
            'status' => true,
            'data' => $carac
        ], 201);
    }

    public function updateCaracteristica(CaracteristicasRequest $request, $id)
    {
        $catacte = CaracteristicasProducto::find($id);
        $catacte->productos_id          = $request->productos_id;
        $catacte->nombre                = $request->nombre;
        $catacte->interes               = $request->interes;
        $catacte->mora                  = $request->mora;
        $catacte->codigo                = $request->codigo;
        // $catacte->monto_minimo          = $request->monto_minimo;
        $catacte->monto_maximo          = $request->monto_maximo;
        // $catacte->tiempo_minimo         = $request->tiempo_minimo;
        $catacte->tiempo_maximo         = $request->tiempo_maximo;
        $catacte->tipo_amortizacion     = $request->tipo_amortizacion;
        $catacte->cobro_intereses       = $request->cobro_intereses;
        $catacte->periodicidad          = $request->periodicidad;


        $catacte->save();

        return response()->json([
            'status' => true,
            'data' => $catacte
        ], 200);
    }

    public function deletePCaracteristica($id)
    {
        $catacte = CaracteristicasProducto::find($id);
        $catacte->delete();

        return response()->json([
            'status' => true,
            'message' => 'Caracteristica Eliminado'
        ], 200);
    }
}
