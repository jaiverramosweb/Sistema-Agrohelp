<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_users_can_authenticate_using_the_login_screen(): void
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();

        $roleID = auth()->user()->role_id;

        // dd($roleID);

        if ($roleID == 4) {
            // return redirect()->intended(RouteServiceProvider::CLIENT);
            $response->assertRedirect(RouteServiceProvider::CLIENT);
        } elseif ($roleID == 5) {
            // return redirect()->intended(RouteServiceProvider::CLIENT);
            $response->assertRedirect(RouteServiceProvider::CLIENT);
        } else {
            // return redirect()->intended(RouteServiceProvider::HOME);
            $response->assertRedirect(RouteServiceProvider::HOME);
        }

        // $response->assertRedirect(RouteServiceProvider::HOME);
    }

    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }
}
