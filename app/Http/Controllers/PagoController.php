<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PagoController extends Controller
{
    public function index(Request $request)
    {
        if (!hasPermissionModule('pago', 'read', 'pago')) {
            return to_route('dashboard');
        }

        $permissions = permissionModule('pago', '', true);

        return Inertia::render('Pagos/Pagar', [
            'permissions' => $permissions
        ]);
    }
}
