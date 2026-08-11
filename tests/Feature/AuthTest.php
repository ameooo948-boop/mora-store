<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register(): void
    {
        Notification::fake();

        $response = $this->post(
            route('register.submit'),
            [
                'name' => 'Test User',
                'email' => 'test@example.com',
                'phone' => '01012345678',
                'password' => 'Password123',
                'password_confirmation' => 'Password123',
            ]
        );

        $response->assertRedirect(
            route('home')
        );

        $this->assertDatabaseHas(
            'users',
            [
                'email' => 'test@example.com',
                'name' => 'Test User',
            ]
        );

        $user = User::where(
            'email',
            'test@example.com'
        )->first();

        $this->assertTrue(
            Hash::check(
                'Password123',
                $user->password
            )
        );

        $this->assertAuthenticatedAs(
            $user
        );

        Notification::assertSentTo(
            $user,
            \Illuminate\Auth\Notifications\VerifyEmail::class
        );
    }

    public function test_user_can_login_with_valid_credentials(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('Password123'),
            'email_verified_at' => now(),
        ]);

        $response = $this->post(
            route('login.submit'),
            [
                'email' => 'test@example.com',
                'password' => 'Password123',
            ]
        );

        $response->assertRedirect(
            route('home')
        );

        $this->assertAuthenticatedAs(
            $user
        );
    }

    public function test_user_cannot_login_with_invalid_credentials(): void
    {
        User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('Password123'),
            'email_verified_at' => now(),
        ]);

        $response = $this->post(
            route('login.submit'),
            [
                'email' => 'test@example.com',
                'password' => 'WrongPassword',
            ]
        );

        $response->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_unverified_user_is_redirected_to_verification_page(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('Password123'),
            'email_verified_at' => null,
        ]);

        $response = $this->post(
            route('login.submit'),
            [
                'email' => 'test@example.com',
                'password' => 'Password123',
            ]
        );

        $response->assertRedirect(
            route('verification.notice')
        );

        $this->assertAuthenticatedAs(
            $user
        );
    }

    public function test_authenticated_user_can_logout(): void
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $response = $this
            ->actingAs($user)
            ->post(
                route('logout')
            );

        $response->assertRedirect('/login');

        $this->assertGuest();
    }

    public function test_settings_table_exists(): void
    {
        $this->assertTrue(
            Schema::hasTable('settings')
        );
    }
}
