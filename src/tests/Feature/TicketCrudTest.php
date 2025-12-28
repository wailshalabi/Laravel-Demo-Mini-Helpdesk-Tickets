<?php

namespace Tests\Feature;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TicketCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_ticket(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('tickets.store'), [
                'title' => 'My printer is on fire',
                'body' => 'It is definitely smoking.',
                'priority' => 'high',
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('tickets', [
            'title' => 'My printer is on fire',
            'created_by' => $user->id,
        ]);
    }

    public function test_user_can_update_own_ticket(): void
    {
        $user = User::factory()->create();
        $ticket = Ticket::factory()->create(['created_by' => $user->id, 'status' => 'open']);

        $this->actingAs($user)
            ->put(route('tickets.update', $ticket), [
                'title' => $ticket->title,
                'body' => $ticket->body,
                'status' => 'in_progress',
                'priority' => $ticket->priority,
            ])
            ->assertRedirect(route('tickets.show', $ticket));

        $this->assertDatabaseHas('tickets', [
            'id' => $ticket->id,
            'status' => 'in_progress',
        ]);
    }
}
