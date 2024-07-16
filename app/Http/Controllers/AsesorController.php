<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Asesore;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AsesorController extends Controller
{
    public function index(Request $request)
    {
        // if (!hasPermissionModule('asesores', 'read', 'asesores')) {
        //     return to_route('dashboard');
        // }

        $permissions = permissionModule('asesores', '', true);
        $asesores = $this->pagination($request);
        return Inertia::render('Products/Asesor/Index', [
            'permissions' => $permissions,
            'asesores' => $asesores,
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
            $h = Asesore::select([
                "asesores.*",
            ]);

            $h->orderBy('asesores.' . $order_field, $order_type);
            $show = $h->paginate($entries);
        } else {

            $h = Asesore::select([
                "asesores.*",
            ]);

            $this->search_ = $search;

            $h->where(function ($query) {

                $campos = [
                    "asesores.name"
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
        $asesor = new Asesore();
        $asesor->name = $request->name;
        $asesor->description = isset($request->description) ? $request->description : '';
        $asesor->save();

        return response()->json($asesor, 201);
    }

    public function getAll()
    {
        $asesor = Asesore::all();

        return response()->json($asesor, 201);
    }

    public function update(Request $request, $id)
    {
        $asesor = Asesore::find($id);
        $asesor->name = $request->name;
        $asesor->description = isset($request->description) ? $request->description : '';
        $asesor->save();

        return response()->json($asesor, 200);
    }

    public function distroy($id)
    {
        Asesore::find($id)->delete();
        return response()->json('Eliminado conexito', 200);
    }
}
