<?php

namespace App\Http\Controllers;

use App\Http\Requests\GarantiaRequest;
use App\Models\Garantia;
use Illuminate\Http\Request;

class GarantiaController extends Controller
{
    public function index()
    {
        $garantia = Garantia::all();

        return response()->json([
            'status' => true,
            'data' => $garantia
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
            $h = Garantia::select([
                "garantias.*",
                "caracteristicas_productos.nombre as caracteristica",
            ]);

            $h->join('caracteristicas_productos', 'garantias.caracteristicas_productos_id', 'caracteristicas_productos.id');
            $h->orderBy('garantias.' . $order_field, $order_type);
            $show = $h->paginate($entries);
        } else {

            $h = Garantia::select([
                "garantias.*",
                "caracteristicas_productos.nombre as caracteristica",
            ]);

            $h->join('caracteristicas_productos', 'garantias.caracteristicas_productos_id', 'caracteristicas_productos.id');

            $this->search_ = $search;

            $h->where(function ($query) {

                $campos = [
                    "garantias.nombre"
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

    public function save(GarantiaRequest $request)
    {
        $garantia = new Garantia();

        $garantia->caracteristicas_productos_id     = $request->caracteristicas_productos_id;
        $garantia->tipo                             = $request->tipo;
        $garantia->nombre                           = $request->nombre;
        $garantia->numero                           = $request->numero;
        $garantia->codigo                           = $request->codigo;
        $garantia->indicador                        = 'En espera';

        $garantia->save();

        return response()->json([
            'status' => true,
            'data' => $garantia
        ], 201);
    }

    public function update(GarantiaRequest $request, $id)
    {
        $garantia = Garantia::find($id);
        $garantia->caracteristicas_productos_id     = $request->caracteristicas_productos_id;
        $garantia->tipo                             = $request->tipo;
        $garantia->nombre                           = $request->nombre;
        $garantia->numero                           = $request->numero;
        $garantia->codigo                           = $request->codigo;

        $garantia->save();

        return response()->json([
            'status' => true,
            'data' => $garantia
        ], 200);
    }

    public function delete($id)
    {
        $garantia = Garantia::find($id);
        $garantia->delete();

        return response()->json([
            'status' => true,
            'message' => 'Garantia Eliminada'
        ], 200);
    }
}
