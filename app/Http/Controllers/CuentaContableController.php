<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CuentasContable;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CuentaContableController extends Controller
{
    public function index(Request $request)
    {
        // if (!hasPermissionModule('cuenta', 'read', 'cuenta')) {
        //     return to_route('dashboard');
        // }

        $permissions = permissionModule('cuenta', '', true);
        $cuenta = $this->pagination($request);
        return Inertia::render('Products/CuentaContable/Index', [
            'permissions' => $permissions,
            'cuenta' => $cuenta,
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
            $h = CuentasContable::select([
                "cuentas_contables.*",
            ]);

            $h->orderBy('cuentas_contables.' . $order_field, $order_type);
            $show = $h->paginate($entries);
        } else {

            $h = CuentasContable::select([
                "cuentas_contables.*",
            ]);

            $this->search_ = $search;

            $h->where(function ($query) {

                $campos = [
                    "cuentas_contables.name"
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

    public function save(Request $request)
    {
        $asesor = new CuentasContable();
        $asesor->tipo   = isset($request->tipo) ? $request->tipo : '';
        $asesor->nombre = isset($request->nombre) ? $request->nombre : '';
        $asesor->numero = isset($request->numero) ? $request->numero : '';
        $asesor->save();

        return response()->json($asesor, 201);
    }

    public function update(Request $request, $id)
    {
        $asesor = CuentasContable::find($id);
        $asesor->tipo   = isset($request->tipo) ? $request->tipo : '';
        $asesor->nombre = isset($request->nombre) ? $request->nombre : '';
        $asesor->numero = isset($request->numero) ? $request->numero : '';
        $asesor->save();

        return response()->json($asesor, 200);
    }

    public function distroy($id)
    {
        CuentasContable::find($id)->delete();
        return response()->json('Eliminado conexito', 200);
    }

    public function getAll(){
        $cuentas = CuentasContable::all();
        return response()->json($cuentas, 200);
    }
}
