<?php

namespace App\Http\Controllers;

use App\Mail\TicketCreated;
use App\Models\Category;
use App\Models\Ticket;
use App\Models\TicketCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;

class TicketController extends Controller
{
    public function index(Request $request)
    {
        /* $tickets = Ticket::with('category')->paginate(10);

        return Inertia::render('Tickets/Index', [
            'tickets' => $tickets,

        ]); */
        $search = $request->input('search');
        $status = $request->input('status');
        $priority = $request->input('priority');
        $category = $request->input('category');

        $tickets = Ticket::query()
        ->with('category')
            ->when($search, function ($query, $search) {
                $query->where('subject', 'like', "%{$search}%");
            })
            ->when($status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->when($priority, function ($query, $priority) {
                $query->where('priority', $priority);
            })
            ->when($category, function ($query, $category) {
                $query->whereHas('category', function ($query) use ($category) {
                    if ($category !== '') {
                        $query->where('category_id', $category);
                    }
                    /* $query->where('name', 'like', "%{$category}%"); */
                });
            })
            ->paginate(10)
            ->withQueryString()
            ->through(fn($ticket) => [
                'id' => $ticket->id,
                'subject' => $ticket->subject,
                'status' => $ticket->status,
                'priority' => $ticket->priority,
                'category' => $ticket->category->name,
            ]);

        $filters = $request->only(['search', 'status', 'priority', 'category']);

        $categories = Category::all();

        return Inertia::render('Tickets/Index', [
            'tickets' => $tickets,
            'filters' => $filters,
            'categories' => $categories,
        ]);
    }
    public function edit(Ticket $ticket)
    {
        $categories = Category::all();
        $agents = User::where('role', 'agent')->get();
        return Inertia::render('Tickets/Edit', [
            'ticket' => $ticket,
            'categories' => $categories,
            'agents' => $agents,
        ]);
    }

    public function update(Request $request, Ticket $ticket)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:open,closed',
            'priority' => 'required|in:low,medium,high',
            'category_id' => 'required|exists:categories,id',
            'agent_id' => 'nullable|exists:users,id',
        ]);

        $ticket->update([
            'subject' => $request->subject,
            'description' => $request->description,
            'status' => $request->status,
            'priority' => $request->priority,
            'category_id' => $request->category_id,
            'agent_id' => $request->agent_id,
        ]);

        return redirect()->route('tickets.index')->with('success', 'Ticket updated successfully.');
    }

    public function create()
    {
        $categories = Category::all();
        return Inertia::render('Tickets/Create', [
            'categories' => $categories
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:low,medium,high',
            'category_id' => 'required|exists:categories,id',
        ]);

        $ticket = Ticket::create([
            'subject' => $request->subject,
            'description' => $request->description,
            'status' => 'open',
            'priority' => $request->priority,
            'user_id' => auth()->id(),
            'category_id' => $request->category_id,
        ]);

        Mail::to(auth()->user()->email)->send(new TicketCreated($ticket));

        return redirect()->route('tickets.index')->with([
            'message' => 'Ticket created successfully!',
            'type' => 'success'
        ]);

    }
    public function destroy($id)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->delete();

        return redirect()->route('tickets.index')->with('Ticket deleted successfully', 'success');
    }
    public function show($id)
    {
        $ticket = Ticket::with(['category', 'user', 'agent'])->findOrFail($id);
        $agents = User::where('role', 'agent')->get();

        return Inertia::render('Tickets/Show', [
            'ticket' => $ticket,
            'agents' => $agents
        ]);
    }

}
