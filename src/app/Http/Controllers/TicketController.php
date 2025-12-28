<?php

namespace App\Http\Controllers;

use App\Events\TicketCreated;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class TicketController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $this->authorize('viewAny', Ticket::class);
        $user = auth()->user();

        $tickets = Ticket::query()
            ->when(!$user->isAdmin(), function ($q) use ($user) {
                $q->where('created_by', $user->id)
                  ->orWhere('assigned_to', $user->id);
            })
            ->latest()
            ->paginate(10);

        $stats = Cache::remember("dashboard_stats_user_{$user->id}", 30, function () use ($user) {
            $baseQuery = function () use ($user) {
                $q = Ticket::query();
                if (!$user->isAdmin()) {
                    $q->where('created_by', $user->id)->orWhere('assigned_to', $user->id);
                }
                return $q;
            };
            return [
                'open' => $baseQuery()->where('status','open')->count(),
                'in_progress' => $baseQuery()->where('status','in_progress')->count(),
                'closed' => $baseQuery()->where('status','closed')->count(),
            ];
        });

        return view('tickets.index', compact('tickets', 'stats'));
    }

    public function create()
    {
        $this->authorize('create', Ticket::class);
        $agents = User::whereIn('role', ['agent','admin'])->orderBy('name')->get();
        return view('tickets.create', compact('agents'));
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
            'created_by' => auth()->id(),
            'assigned_to' => $data['assigned_to'] ?? null,
        ]);

        TicketCreated::dispatch($ticket->load('assignee'));

        return redirect()->route('tickets.show', $ticket)->with('ok', 'Ticket created.');
    }

    public function show(Ticket $ticket)
    {
        $this->authorize('view', $ticket);
        $ticket->load(['creator','assignee','comments.user']);
        return view('tickets.show', compact('ticket'));
    }

    public function edit(Ticket $ticket)
    {
        $this->authorize('update', $ticket);
        $agents = User::whereIn('role', ['agent','admin'])->orderBy('name')->get();
        return view('tickets.edit', compact('ticket','agents'));
    }

    public function update(Request $request, Ticket $ticket)
    {
        $this->authorize('update', $ticket);

        $data = $request->validate([
            'title' => ['required','string','max:255'],
            'body' => ['required','string'],
            'status' => ['required','in:open,in_progress,closed'],
            'priority' => ['required','in:low,medium,high'],
            'assigned_to' => ['nullable','exists:users,id'],
        ]);

        // Only admins can change assignment
        if (!auth()->user()->isAdmin()) {
            unset($data['assigned_to']);
        }

        $ticket->update($data);

        return redirect()->route('tickets.show', $ticket)->with('ok', 'Ticket updated.');
    }

    public function destroy(Ticket $ticket)
    {
        $this->authorize('delete', $ticket);
        $ticket->delete();
        return redirect()->route('tickets.index')->with('ok', 'Ticket deleted.');
    }
}
