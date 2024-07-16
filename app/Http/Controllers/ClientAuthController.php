<?php

namespace App\Http\Controllers;

use App\Models\CaracteristicasProducto;
use App\Models\Client;
use App\Models\IngresoEgresoCredito;
use App\Models\LineaCredito;
use App\Models\PatrimonioCredito;
use App\Models\Producto;
use App\Models\ReferenciaCredito;
use App\Models\SolServicio;
use App\Models\TarjetasCredito;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ClientAuthController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $client = Client::where('users_id', $user->id)->first();
        $solicitudes = SolServicio::select(['id', 'clientes_id', 'producto_id', 'estado_solicitud', 'monto', 'tiempo'])->where('clientes_id', $client->id)->get();

        // foreach ($solicitudes as $value) {
        //     $value->producto = CaracteristicasProducto::find($value->producto_id);

        //     if (isset($value->producto)) {
        //         $product = Producto::find($value->producto->productos_id);
        //         $value->producto->nombre_producto = $product->nombre;
        //     }
        // }

        return Inertia::render('Clients/Index', [
            'cliente'       => $user,
            'info'          => $client,
            'solicitudes'   => $solicitudes,
        ]);
    }

    public function dashboard()
    {
        return Inertia::render('Dashboard');
    }

    public function creditos()
    {
        $user_id = Auth::user()->id;
        $client = Client::where('users_id', $user_id)->first();

        $info = SolServicio::select(['id', 'clientes_id', 'producto_id', 'estado_solicitud', 'monto', 'tiempo'])->where('clientes_id', $client->id)->get();

        return response()->json($info, 200);
    }

    public function perfil()
    {
        $user_id = Auth::user()->id;

        $client = Client::where('users_id', $user_id)->first();

        $client->referencias = ReferenciaCredito::where('clientes_id', $client->id)->first();
        $client->linea = LineaCredito::where('clientes_id', $client->id)->first();
        $client->parimonio = PatrimonioCredito::where('clientes_id', $client->id)->first();
        $client->ingreso = IngresoEgresoCredito::where('clientes_id', $client->id)->first();
        $client->creditos = TarjetasCredito::where('clientes_id', $client->id)->first();

        return Inertia::render('Clients/CrearCliente', [
            'cliente' => $client
        ]);
    }
}
