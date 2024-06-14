<?php

namespace App\Http\Controllers;

use App\Models\Interes;
use Illuminate\Http\Request;
use Inertia\Inertia;

class InteresController extends Controller
{
    public function index(Request $request)
    {
        if (!hasPermissionModule('config', 'read', 'config')) {
            return to_route('dashboard');
        }
        $permissions = permissionModule('users', '', true);
        $interes = $this->pagination($request);
        return Inertia::render('Products/Interes/Index', [
            'permissions' => $permissions,
            'interes' => $interes,
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
            $h = Interes::select([
                "interes.*",
            ]);

            $h->orderBy('interes.' . $order_field, $order_type);
            $show = $h->paginate($entries);
        } else {

            $h = Interes::select([
                "interes.*",
            ]);

            $this->search_ = $search;

            $h->where(function ($query) {

                $campos = [
                    "interes.ibr",
                    "interes.corriente"
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

    public function getAll()
    {
        $intereses = Interes::all();
        return response()->json($intereses, 200);
    }

    public function update(Request $request, $id)
    {
        $interes = Interes::find($id)->update([
            'valor' => $request->valor
        ]);
        
        return response()->json($interes, 200);
    }

    public function getMora()
    {
        $interese = Interes::where('name', 'Mora')->first();
        return response()->json($interese, 200);
    }

    public function getInteres()
    {
        $interese = Interes::where('name', 'Corriente')->first();
        return response()->json($interese, 200);
    }
}
