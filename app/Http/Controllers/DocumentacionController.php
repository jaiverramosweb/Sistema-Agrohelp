<?php

namespace App\Http\Controllers;

use App\Http\Requests\DocumentacionRequest;
use App\Models\Documentacion;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DocumentacionController extends Controller
{
    public function index(Request $request)
    {
        if (!hasPermissionModule('config', 'read', 'config')) {
            return to_route('dashboard');
        }
        $permissions = permissionModule('users', '', true);
        $documentos = $this->pagination($request);
        return Inertia::render('Products/Documentacion/Index', [
            'permissions' => $permissions,
            'documentos' => $documentos,
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
            $h = Documentacion::select([
                "documentacions.*",
            ]);

            $h->orderBy('documentacions.' . $order_field, $order_type);
            $show = $h->paginate($entries);
        } else {

            $h = Documentacion::select([
                "documentacions.*",
            ]);

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

    public function getDocumentacion()
    {
        $documentos = Documentacion::select(['id', 'nombre'])->get();

        return response()->json([
            'status' => true,
            'data' => $documentos
        ], 200);
    }

    public function save(DocumentacionRequest $request)
    {
        $documento = new Documentacion();

        $documento->nombre                           = $request->nombre;
        $documento->codigo                           = $request->codigo;
        $documento->indicador                        = 'Avtivo';

        $documento->save();

        return response()->json([
            'status' => true,
            'data' => $documento
        ], 201);
    }

    public function update(DocumentacionRequest $request, $id)
    {
        $documento = Documentacion::find($id);
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
