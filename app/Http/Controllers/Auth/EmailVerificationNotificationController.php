<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     */
    public function store(Request $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            if (auth()->user()->role_id == 4) {
                return redirect()->intended(RouteServiceProvider::CLIENT);
            } elseif (auth()->user()->role_id == 5) {
                return redirect()->intended(RouteServiceProvider::CLIENT);
            } else {
                return redirect()->intended(RouteServiceProvider::HOME);
            }
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('status', 'verification-link-sent');
    }
}
