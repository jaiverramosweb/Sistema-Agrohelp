<?php

namespace App\Http\Controllers;

use App\Http\Requests\DocumentacionRequest;
use App\Models\Documentacion;
use Illuminate\Http\Request;

class DocumentacionController extends Controller
{
    public function index()
    {
        $documento = Documentacion::all();

        return response()->json([
            'status' => true,
            'data' => $documento
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
            $h = Documentacion::select([
                "documentacions.*",
                "caracteristicas_productos.nombre as caracteristica",
            ]);

            $h->join('caracteristicas_productos', 'documentacions.caracteristicas_productos_id', 'caracteristicas_productos.id');
            $h->orderBy('documentacions.' . $order_field, $order_type);
            $show = $h->paginate($entries);
        } else {

            $h = Documentacion::select([
                "documentacions.*",
                "caracteristicas_productos.nombre as caracteristica",
            ]);

            $h->join('caracteristicas_productos', 'documentacions.caracteristicas_productos_id', 'caracteristicas_productos.id');

            $this->search_ = $search;

            $h->where(function ($query) {

                $campos = [
                    "documentacions.nombre"
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

    public function save(DocumentacionRequest $request)
    {
        $documento = new Documentacion();

        $documento->caracteristicas_productos_id     = $request->caracteristicas_productos_id;
        $documento->tipo                             = $request->tipo;
        $documento->nombre                           = $request->nombre;
        $documento->codigo                           = $request->codigo;
        $documento->indicador                        = 'En espera';

        $documento->save();

        return response()->json([
            'status' => true,
            'data' => $documento
        ], 201);
    }

    public function update(DocumentacionRequest $request, $id)
    {
        $documento = Documentacion::find($id);
        $documento->caracteristicas_productos_id     = $request->caracteristicas_productos_id;
        $documento->tipo                             = $request->tipo;
        $documento->nombre                           = $request->nombre;
        $documento->codigo                           = $request->codigo;

        $documento->save();

        return response()->json([
            'status' => true,
            'data' => $documento
        ], 200);
    }

    public function delete($id)
    {
        $documento = Documentacion::find($id);
        $documento->delete();

        return response()->json([
            'status' => true,
            'message' => 'Documentacion Eliminada'
        ], 200);
    }
}
