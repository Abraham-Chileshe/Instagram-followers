<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Task;
use App\Models\TaskSubmission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SubscriptionTest extends TestCase
{
    use RefreshDatabase;

    public function test_unsubscribed_user_cannot_withdraw()
    {
        $user = User::factory()->create([
            'balance_aed' => 500,
            'is_subscribed_to_target' => false,
            'created_at' => now()->subDays(10), // Passed join date check
        ]);

        // Mock an approved task in last 7 days to pass activity check
        $task = Task::create([
            'title' => 'Test Task',
            'description' => 'Test',
            'reward_aed' => 10,
            'instagram_url' => 'http://inst.gr/am',
            'type' => 'like',
        ]);
        TaskSubmission::create([
            'user_id' => $user->id,
            'task_id' => $task->id,
            'status' => 'approved',
            'proof_image_path' => 'test.jpg',
            'created_at' => now()->subDays(2),
        ]);

        $this->actingAs($user)
             ->withSession(['active_access_code' => 'TEST-123']);

        $response = $this->post('/withdraw', [
            'amount_aed' => 100,
            'payment_method' => 'cash',
            'payment_details' => 'Handover',
        ]);

        $response->assertSessionHasErrors(['amount_aed']);
        $this->assertDatabaseMissing('withdrawals', ['user_id' => $user->id]);
    }

    public function test_subscribed_user_can_withdraw()
    {
        $user = User::factory()->create([
            'balance_aed' => 500,
            'is_subscribed_to_target' => true,
            'created_at' => now()->subDays(10),
        ]);

        // Mock activity
        $task = Task::create([
            'title' => 'Test Task',
            'description' => 'Test',
            'reward_aed' => 10,
            'instagram_url' => 'http://inst.gr/am',
            'type' => 'like',
        ]);
        TaskSubmission::create([
            'user_id' => $user->id,
            'task_id' => $task->id,
            'status' => 'approved',
            'proof_image_path' => 'test.jpg',
            'created_at' => now()->subDays(2),
        ]);

        $this->actingAs($user)
             ->withSession(['active_access_code' => 'TEST-123']);

        $response = $this->post('/withdraw', [
            'amount_aed' => 100,
            'payment_method' => 'cash',
            'payment_details' => 'Handover',
        ]);

        $response->assertRedirect('/withdrawals');
        $this->assertDatabaseHas('withdrawals', ['user_id' => $user->id, 'amount_aed' => 100]);
    }
}
