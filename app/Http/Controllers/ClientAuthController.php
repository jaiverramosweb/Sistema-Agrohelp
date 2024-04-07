<?php

namespace App\Http\Controllers;

use App\Models\Client;
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
}
