<?php

namespace App\Http\Controllers\keller;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClientSaveRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Direccion;
use App\Models\User;
use Inertia\Inertia;

class ClientsController extends Controller
{
    public function index(Request $request)
    {
        if (!hasPermissionModule('clients', 'read', 'clients')) {
            return to_route('dashboard');
        }

        $permissions = permissionModule('clients', '', true);
        $clients = $this->pagination($request);

        return Inertia::render('Keller/Clients/Index', [
            'permissions' => $permissions,
            'clients' => $clients,
        ]);
    }

    public $search_;

    public function pagination(Request $request, $pag = 25)
    {
        $entries = $pag;

        if ($request->show) $entries =  $request->show;

        $search         = $request->search      == "" ?  "" : $request->search;
        // $order_type     = $request->order_type  == "" ? "DESC" :$request->order_type;
        $order_type     = $request->order_type  == "" ? "ASC" : $request->order_type;
        $order_field    = $request->order_field == "" ? "id" : $request->order_field;

        if ($search == "") {
            $h = Client::select("*",);

            $h->orderBy($order_field, $order_type);
            $show = $h->paginate($entries);
        } else {

            $h = Client::select("*",);

            $this->search_ = $search;

            $h->where(function ($query) {

                $campos = [
                    "company"
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


    public function store(ClientSaveRequest $request)
    {

        $user = '';
        if (isset($request->password)) {
            $user = User::create([
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role_id' => 5
            ]);
        } else {
            $user = auth()->user();
        }

        // dd($user);

        $client = new Client();
        $client->users_id           = $user->id;
        $client->id_user_sap        = isset($request->id_user_sap) ? $request->id_user_sap : '';
        $client->id_prove_sap       = isset($request->id_prove_sap) ? $request->id_prove_sap : '';
        $client->nombre             = $request->nombre;
        $client->apellido           = isset($request->apellido) ? $request->apellido : '';
        $client->tipo_documento     = $request->tipo_documento;
        $client->documento          = $request->documento;
        $client->email              = $request->email;
        $client->estado_persona     = 'Activo';
        $client->indicador_persona  = 'En espara';
        $client->role_id            = 5;

        $client->save();


        return response()->json([
            "status"    => true,
            "data"      => $client
        ], 201);
    }

    public function show(Client $client)
    {
        if (!hasPermissionModule('clients', 'read', 'clients')) {
            return to_route('dashboard');
        }

        $permissions = permissionModule('clients', '', true);

        $direcciones = Direccion::where('clients_id', $client->id)->get();

        return Inertia::render('Keller/Clients/Details', [
            'permissions' => $permissions,
            'client' => $client,
            'direcciones' => $direcciones,
        ]);
    }

    public function update(Request $request, Client $client)
    {
        if (!hasPermissionModule('clients', 'update', 'clients')) {
            return to_route('dashboard');
        }

        $client->id_user_sap        = isset($request->id_user_sap) ? $request->id_user_sap : '';
        $client->id_prove_sap       = isset($request->id_prove_sap) ? $request->id_prove_sap : '';
        $client->nombre             = $request->nombre;
        $client->apellido           = isset($request->apellido) ? $request->apellido : '';
        $client->tipo_documento     = $request->tipo_documento;
        $client->documento          = $request->documento;
        $client->email              = $request->email;

        $client->save();

        return response()->json([
            "status"    => true,
            "data"      => $client
        ], 200);
    }

    public function destroy(Client $client)
    {
        if (!hasPermissionModule('clients', 'delete', 'clients')) {
            return response()->json([
                'msg'   => 'Sin permisos.',
                'state' => 'error',
                'data'  => []
            ]);
        }

        $client->delete();

        return response()->json([
            "status" => true,
            "msj"   => "Eliminado con exito"
        ]);
    }

    public function passwordUpdate(Request $request)
    {
        $client = Client::where('users_id', $request->id)->first();

        User::find($request->id)->update([
            'password' => Hash::make($client->documento),
        ]);

        return response()->json('Restaurado con exito', 200);
    }
}
