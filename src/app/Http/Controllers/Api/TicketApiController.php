<?php

namespace App\Http\Controllers\Api;

use App\Events\TicketCreated;
use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketApiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index(Request $request)
    {
        $this->authorize('viewAny', Ticket::class);
        $user = $request->user();

        $tickets = Ticket::query()
            ->when(!$user->isAdmin(), function ($q) use ($user) {
                $q->where('created_by', $user->id)
                  ->orWhere('assigned_to', $user->id);
            })
            ->latest()
            ->paginate(10);

        return response()->json($tickets);
    }

    public function store(Request $request)
    {
        $this->authorize('create', Ticket::class);

        $data = $request->validate([
            'title' => ['required','string','max:255'],
            'body' => ['required','string'],
            'priority' => ['required','in:low,medium,high'],
            'assigned_to' => ['nullable','exists:users,id'],
        ]);

        $ticket = Ticket::create([
            'title' => $data['title'],
            'body' => $data['body'],
            'priority' => $data['priority'],
            'status' => 'open',
            'created_by' => $request->user()->id,
            'assigned_to' => $data['assigned_to'] ?? null,
        ]);

        TicketCreated::dispatch($ticket->load('assignee'));

        return response()->json($ticket, 201);
    }

    public function show(Request $request, Ticket $ticket)
    {
        $this->authorize('view', $ticket);
        return response()->json($ticket->load(['creator','assignee','comments.user']));
    }

    public function update(Request $request, Ticket $ticket)
    {
        $this->authorize('update', $ticket);

        $data = $request->validate([
            'title' => ['sometimes','string','max:255'],
            'body' => ['sometimes','string'],
            'status' => ['sometimes','in:open,in_progress,closed'],
            'priority' => ['sometimes','in:low,medium,high'],
            'assigned_to' => ['sometimes','nullable','exists:users,id'],
        ]);

        if (!$request->user()->isAdmin()) {
            unset($data['assigned_to']);
        }

        $ticket->update($data);

        return response()->json($ticket);
    }

    public function destroy(Request $request, Ticket $ticket)
    {
        $this->authorize('delete', $ticket);
        $ticket->delete();
        return response()->json(['ok' => true]);
    }
}
