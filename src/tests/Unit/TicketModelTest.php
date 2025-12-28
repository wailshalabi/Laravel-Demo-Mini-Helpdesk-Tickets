<?php

namespace Tests\Unit;

use App\Models\Comment;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TicketModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_ticket_relationships(): void
    {
        $creator = User::factory()->create();
        $assignee = User::factory()->create();

        $ticket = Ticket::factory()->create([
            'created_by' => $creator->id,
            'assigned_to' => $assignee->id,
        ]);

        $comment = Comment::create([
            'ticket_id' => $ticket->id,
            'user_id' => $creator->id,
            'body' => 'Test comment',
        ]);

        $this->assertEquals($creator->id, $ticket->creator->id);
        $this->assertEquals($assignee->id, $ticket->assignee->id);

        $this->assertCount(1, $ticket->comments);
        $this->assertEquals($creator->id, $ticket->comments->first()->user->id);
    }
}
