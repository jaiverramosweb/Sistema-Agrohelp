<?php

namespace App\Http\Controllers;

use App\Http\Requests\MetodoPagoRequest;
use App\Models\MetodoPago;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MetodoPagoController extends Controller
{
    public function index(Request $request)
    {
        if (!hasPermissionModule('config', 'read', 'config')) {
            return to_route('dashboard');
        }
        $permissions = permissionModule('users', '', true);
        $pago = $this->pagination($request);
        return Inertia::render('Products/MetodoPago/Index', [
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
        $order_type     = $request->order_type  == "" ? "ASC" : $request->order_type;
        $order_field    = $request->order_field == "" ? "id" : $request->order_field;

        if ($search == "") {
            $h = MetodoPago::select([
                "metodo_pagos.*",
            ]);

            $h->orderBy('metodo_pagos.' . $order_field, $order_type);
            $show = $h->paginate($entries);
        } else {

            $h = MetodoPago::select([
                "metodo_pagos.*",
            ]);

            $this->search_ = $search;

            $h->where(function ($query) {

                $campos = [
                    "metodo_pagos.name"
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

    public function getmetodoPago()
    {
        $metodo = MetodoPago::all();
        return response()->json($metodo, 200);
    }

    public function getDocumentacion()
    {
        $documentos = MetodoPago::select(['id', 'nombre'])->get();

        return response()->json([
            'status' => true,
            'data' => $documentos
        ], 200);
    }

    public function save(MetodoPagoRequest $request)
    {
        $pago = new MetodoPago();

        $pago->name         = $request->name;
        $pago->description  = $request->description;

        $pago->save();

        return response()->json([
            'status' => true,
            'data' => $pago
        ], 201);
    }

    public function update(MetodoPagoRequest $request, $id)
    {
        $pago = MetodoPago::find($id);
        $pago->name         = $request->name;
        $pago->description  = $request->description;

        $pago->save();

        return response()->json([
            'status' => true,
            'data' => $pago
        ], 200);
    }

    public function delete($id)
    {
        $pago = MetodoPago::find($id);
        $pago->delete();

        return response()->json([
            'status' => true,
            'message' => 'Metodo de pago Eliminada'
        ], 200);
    }
}
