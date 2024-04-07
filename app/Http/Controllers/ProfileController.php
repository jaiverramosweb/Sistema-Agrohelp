<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): Response
    {
        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $user = $request->all();
        $user = json_decode( $user['data'] );
        $user = [
            "nombre" => $user->nombre ,
            "apellido" => $user->apellido ,
            "segundo_nombre" => $user->segundo_nombre ,
            "segundo_apellido" => $user->segundo_apellido ,
            "documento" => $user->documento ,
            "email" => $user->email 
        ];

        if ( $request->hasFile('file_') )
        {
            $name = time().'_'.$request->file('file_')->getClientOriginalName();
            $path    = 'public/perfil/images/'.$name;
            $path_    = 'perfil/images/'.$name;
            $user =  $request->all() ;

            
            
            Storage::disk('local')->put( $path ,  \File::get( $request->file('file_') ) );
            
            $user["avatar"] = '/storage/'.$path_ ;
            
            
        }

        $user = User::find( $request->user()->id )
        ->update( $user );

        $request->user()->save();

        return Redirect::route('profile.edit');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

     /**
     * Delete the user's account.
     */
    public function destroyAvatarImg(Request $request): RedirectResponse
    {
        $user = User::find( $request->user()->id )
        ->update( ["avatar" => '' ] );
        return Redirect::to('/profile');
    }
}
