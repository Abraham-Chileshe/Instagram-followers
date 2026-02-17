<?php

namespace Tests\Feature;

use App\Models\AccessCode;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register_with_password()
    {
        $code = AccessCode::create([
            'code' => 'REG-123',
            'status' => 'active',
            'expires_at' => null,
        ]);

        $this->post('/access-code', ['code' => 'REG-123']);

        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'payment_preference' => 'bank',
        ]);

        $response->assertRedirect('/');
        $this->assertDatabaseHas('users', ['email' => 'test@example.com']);
        
        $user = User::where('email', 'test@example.com')->first();
        $this->assertTrue(\Illuminate\Support\Facades\Hash::check('password123', $user->password));
    }

    public function test_user_can_login_with_email_and_password()
    {
        $user = User::factory()->create([
            'email' => 'login@example.com',
            'password' => \Illuminate\Support\Facades\Hash::make('secret123'),
        ]);

        $response = $this->post('/login', [
            'email' => 'login@example.com',
            'password' => 'secret123',
        ]);

        $response->assertRedirect('/');
        $this->assertAuthenticatedAs($user);
    }

    public function test_user_cannot_login_with_wrong_password()
    {
        $user = User::factory()->create([
            'email' => 'wrong@example.com',
            'password' => \Illuminate\Support\Facades\Hash::make('secret123'),
        ]);

        $response = $this->post('/login', [
            'email' => 'wrong@example.com',
            'password' => 'wrong-pass',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }
}
