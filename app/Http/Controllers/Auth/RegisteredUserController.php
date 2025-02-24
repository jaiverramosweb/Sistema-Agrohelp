<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|string|email|max:255|unique:' . User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'role_id'   => 5
        ]);

        Client::create([
            'users_id'          => $user->id,
            'nombre'            => $request->name,
            'tipo_documento'    => $request->tipo,
            'documento'         => $request->documento,
            'email'             => $request->email,
        ]);

        event(new Registered($user));

        Auth::login($user);

        $roleID = auth()->user()->role_id;

        if ($roleID == 4) {
            return redirect()->intended(RouteServiceProvider::CLIENT);
        } elseif ($roleID == 5) {
            return redirect()->intended(RouteServiceProvider::CLIENT);
        } else {
            return redirect()->intended(RouteServiceProvider::HOME);
        }
    }
}
