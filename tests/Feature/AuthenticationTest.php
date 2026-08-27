<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_new_customer_can_register_and_is_not_granted_admin_access(): void
    {
        $response = $this->post(route('register.store'), [
            'name' => 'Ada Cliente',
            'email' => 'ada@example.com',
            'password' => 'Password123',
            'password_confirmation' => 'Password123',
            'is_admin' => true,
        ]);

        $response->assertRedirect(route('home'));
        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', [
            'email' => 'ada@example.com',
            'is_admin' => false,
        ]);
    }

    public function test_customer_can_log_in_and_log_out(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('Password123'),
        ]);

        $loginResponse = $this->post(route('login.store'), [
            'email' => $user->email,
            'password' => 'Password123',
        ]);

        $loginResponse->assertRedirect(route('home'));
        $this->assertAuthenticatedAs($user);

        $logoutResponse = $this->post(route('logout'));

        $logoutResponse->assertRedirect(route('home'));
        $this->assertGuest();
    }

    public function test_invalid_credentials_are_rejected_with_a_visible_error(): void
    {
        $user = User::factory()->create();

        $response = $this->from(route('login'))->post(route('login.store'), [
            'email' => $user->email,
            'password' => 'incorrecta',
        ]);

        $response
            ->assertRedirect(route('login'))
            ->assertSessionHasErrors(['email' => 'El correo o la contraseña no son correctos.']);
        $this->assertGuest();
    }
}
