<?php

namespace Tests\Feature;

use App\Models\AccessCode;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AccessCodeTest extends TestCase
{
    use RefreshDatabase;

    public function test_normal_access_codes_can_be_verified()
    {
        $code = AccessCode::create([
            'code' => 'NORMAL-123',
            'status' => 'active',
            'expires_at' => now()->addDays(1),
        ]);

        $response = $this->post('/access-code', [
            'code' => 'NORMAL-123',
        ]);

        $response->assertRedirect('/register');
        $this->assertEquals('NORMAL-123', session('pending_access_code'));
    }

    public function test_expired_access_codes_cannot_be_verified()
    {
        $code = AccessCode::create([
            'code' => 'EXPIRED-123',
            'status' => 'active',
            'expires_at' => now()->subDays(1),
        ]);

        $response = $this->post('/access-code', [
            'code' => 'EXPIRED-123',
        ]);

        $response->assertSessionHasErrors('code');
    }

    public function test_permanent_access_codes_can_be_verified()
    {
        $code = AccessCode::create([
            'code' => 'PERM-123',
            'status' => 'active',
            'expires_at' => null,
        ]);

        $response = $this->post('/access-code', [
            'code' => 'PERM-123',
        ]);

        $response->assertRedirect('/register');
        
        // Wait, if it redirects to register it means no user was found for the code
        // and session 'pending_access_code' was set.
        // Let's check AccessCodeController logic again.
    }

    public function test_permanent_access_codes_are_reusable_after_registration()
    {
        // 1. Create a permanent code
        $code = AccessCode::create([
            'code' => 'REUSABLE-123',
            'status' => 'active',
            'expires_at' => null,
        ]);

        // 2. Verify the code (this sets pending_access_code in session)
        $this->post('/access-code', [
            'code' => 'REUSABLE-123',
        ])->assertRedirect('/register');

        // 3. Register using this code
        $response = $this->post('/register', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'payment_preference' => 'bank',
        ]);

        $response->assertRedirect('/');
        
        // Check database - status should still be active
        $this->assertEquals('active', $code->fresh()->status);
        
        // 4. Logout (simulated by clearing session)
        session()->flush();
        
        // 5. Try verifying the SAME code again - it should still work!
        $response2 = $this->post('/access-code', [
            'code' => 'REUSABLE-123',
        ]);
        $response2->assertRedirect('/');
        $this->assertEquals('active', $code->fresh()->status);
    }

    public function test_normal_access_codes_are_marked_used_after_registration()
    {
        $code = AccessCode::create([
            'code' => 'ONE-TIME-123',
            'status' => 'active',
            'expires_at' => now()->addDays(1),
        ]);

        // 1. Verify the code
        $this->post('/access-code', [
            'code' => 'ONE-TIME-123',
        ])->assertRedirect('/register');

        // 2. Register
        $response = $this->post('/register', [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'payment_preference' => 'bank',
        ]);

        $response->assertRedirect('/');
        
        // Check database - status should be used
        $this->assertEquals('used', $code->fresh()->status);
    }
}
