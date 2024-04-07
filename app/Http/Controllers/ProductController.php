<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Producto;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        if (!hasPermissionModule('productos', 'read', 'productos')) {
            return to_route('dashboard');
        }

        $permissions = permissionModule('productos', '', true);

        return Inertia::render('Products/Index', [
            'permissions' => $permissions
        ]);
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
            $h = Producto::select("*",);

            $h->orderBy($order_field, $order_type);
            $show = $h->paginate($entries);
        } else {

            $h = Producto::select("*",);

            $this->search_ = $search;

            $h->where(function ($query) {

                $campos = [
                    "tipo_producto",
                    "nombre",
                    "estado"
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

    public function productos()
    {
        $productos = Producto::all();
        return response()->json([
            'status' => true,
            'data' => $productos
        ], 200);
    }

    public function saveProduct(ProductRequest $request)
    {
        $product = new Producto();

        $product->tipo_producto = $request->tipo_producto;
        $product->nombre        = $request->nombre;
        $product->estado        = 'Activo';
        $product->descripcion   = isset($request->descripcion) ? $request->descripcion : '';
        $product->codigo        =  isset($request->codigo) ? $request->codigo : '';

        $product->save();

        return response()->json([
            'status' => true,
            'data' => $product
        ], 201);
    }

    public function updateProduct(ProductRequest $request, Producto $product)
    {
        $product->tipo_producto = $request->tipo_producto;
        $product->nombre        = $request->nombre;
        $product->descripcion   = isset($request->descripcion) ? $request->descripcion : '';
        $product->codigo        =  isset($request->codigo) ? $request->codigo : '';

        $product->save();

        return response()->json([
            'status' => true,
            'data' => $product
        ], 200);
    }

    public function deleteProduct(Producto $product)
    {
        $product->delete();

        return response()->json([
            'status' => true,
            'message' => 'Producto Eliminado'
        ], 200);
    }
}
