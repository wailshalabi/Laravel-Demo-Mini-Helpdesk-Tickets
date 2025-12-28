<?php

namespace Tests\Feature;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ApiTicketsTest extends TestCase
{
    use RefreshDatabase;

    public function test_api_list_tickets_requires_auth(): void
    {
        $this->getJson('/api/tickets')->assertStatus(401);
    }

    public function test_api_list_tickets_returns_user_scope(): void
    {
        $user = User::factory()->create();
        $other = User::factory()->create();

        Ticket::factory()->create(['created_by' => $user->id, 'title' => 'Mine']);
        Ticket::factory()->create(['created_by' => $other->id, 'title' => 'Not mine']);

        Sanctum::actingAs($user);

        $res = $this->getJson('/api/tickets')->assertOk();
        $this->assertStringContainsString('Mine', $res->getContent());
        $this->assertStringNotContainsString('Not mine', $res->getContent());
    }
}
