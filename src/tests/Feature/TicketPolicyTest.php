<?php

namespace Tests\Feature;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TicketPolicyTest extends TestCase
{
    use RefreshDatabase;

    public function test_creator_can_view_ticket(): void
    {
        $creator = User::factory()->create();
        $ticket = Ticket::factory()->create(['created_by' => $creator->id]);

        $this->actingAs($creator)
            ->get(route('tickets.show', $ticket))
            ->assertOk();
    }

    public function test_random_user_cannot_view_others_ticket(): void
    {
        $creator = User::factory()->create();
        $other = User::factory()->create();
        $ticket = Ticket::factory()->create(['created_by' => $creator->id]);

        $this->actingAs($other)
            ->get(route('tickets.show', $ticket))
            ->assertForbidden();
    }

    public function test_admin_can_delete_ticket(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $ticket = Ticket::factory()->create();

        $this->actingAs($admin)
            ->delete(route('tickets.destroy', $ticket))
            ->assertRedirect(route('tickets.index'));

        $this->assertDatabaseMissing('tickets', ['id' => $ticket->id]);
    }
}
