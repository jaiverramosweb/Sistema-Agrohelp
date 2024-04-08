<?php

namespace App\Http\Controllers;

use App\Http\Requests\GarantiaRequest;
use App\Models\Garantia;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GarantiaController extends Controller
{
    public function index(Request $request)
    {
        if (!hasPermissionModule('config', 'read', 'config')) {
            return to_route('dashboard');
        }
        $permissions = permissionModule('users', '', true);
        $garantias = $this->pagination($request);
        return Inertia::render('Products/Garantias/Index', [
            'permissions' => $permissions,
            'garantias' => $garantias,
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
            $h = Garantia::select([
                "garantias.*",
            ]);
            $h->orderBy('garantias.' . $order_field, $order_type);
            $show = $h->paginate($entries);
        } else {

            $h = Garantia::select([
                "garantias.*",
            ]);

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

    public function getGarantias()
    {
        $garantias = Garantia::select(['id', 'nombre'])->get();
        return response()->json([
            'status' => true,
            'data' => $garantias
        ], 200);
    }

    public function save(GarantiaRequest $request)
    {
        $garantia = new Garantia();

        $garantia->nombre                           = $request->nombre;
        $garantia->codigo                           = $request->codigo;
        $garantia->indicador                        = 'Activo';

        $garantia->save();

        return response()->json([
            'status' => true,
            'data' => $garantia
        ], 201);
    }

    public function update(GarantiaRequest $request, $id)
    {
        $garantia = Garantia::find($id);
        $garantia->nombre                           = $request->nombre;
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
