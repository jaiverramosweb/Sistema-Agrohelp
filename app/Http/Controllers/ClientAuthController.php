<?php

namespace App\Http\Controllers;

use App\Models\CaracteristicasProducto;
use App\Models\Client;
use App\Models\Producto;
use App\Models\SolServicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ClientAuthController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $info = Client::where('email', $user->email)->first();

        return Inertia::render('Clients/Index', [
            'cliente' => $user,
            'info' => $info,
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

        foreach ($info as $value) {
            $value->producto = CaracteristicasProducto::find($value->producto_id);

            if (isset($value->producto)) {
                $product = Producto::find($value->producto->productos_id);
                $value->producto->nombre_producto = $product->nombre;
            }
        }

        // dd($info);

        return Inertia::render('Clients/Creditos', [
            'info' => $info,
        ]);
    }
}
