<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TicketController extends Controller
{
    use AuthorizesRequests;

    public function create()
    {
        return view('tickets.create');
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        if (!$user->isPro() && $user->tickets()->count() >= 5) {
            return redirect()->back()
                ->withErrors(['error' => 'Je hebt het limiet van 50 tickets bereikt. Upgrade naar pro']);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => $user->isPro() ? 'nullable|in:low,medium,high' : 'prohibited',
            'labels' => $user->isPro() ? 'nullable|string' : 'prohibited',
        ]);

        Ticket::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'user_id' => auth()->id(),
            'priority' => $validated['priority'] ?? null,
            'labels' => $validated['labels'] ?? null,
        ]);

        return redirect()->route('tickets.index')
            ->with('success', 'Ticket created successfully.');
    }

   public function index()
    {
        $search = request('search');
        $status = request('status');
        $priority = request('priority');
        $labels = request('labels');

        $query = Ticket::where('user_id', auth()->id());

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                ->orWhere('description', 'like', "%$search%");
            });
        }

        if ($status) {
            $query->where('status', $status);
        }

        if ($priority) {
            $query->where('priority', $priority);
        }

        if ($labels) {
            $query->where('labels', 'like', "%$labels%");
        }

        $tickets = $query->latest()->get();

        return view('tickets.index', compact('tickets'));
    }

    public function show(Ticket $ticket)
    {
        $this->authorize('view', $ticket);
        return view('tickets.show', compact('ticket'));
    }

    public function edit(Ticket $ticket)
    {
        $this->authorize('update', $ticket);
        return view('tickets.edit', compact('ticket'));
    }

    public function update(Request $request, Ticket $ticket)
    {
        $this->authorize('update', $ticket);

        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'status' => 'sometimes|required|in:open,in_progress,closed',
            'priority' => 'sometimes|nullable|in:low,medium,high',
            'labels' => 'sometimes|nullable|string',
        ]);

        $ticket->update($validated);

        return redirect()->route('tickets.show', $ticket)
            ->with('success', 'Ticket updated successfully.');
    }

    public function dashboard()
    {
        $stats = Ticket::where('user_id', auth()->id())
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        return view ('dashboard', compact('stats'));
    }
}
