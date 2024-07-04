<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
	{
		$totalUsers = User::count();
		$totalCategories = Category::count();
        $totalTicketsSolved = Ticket::where('status', 'closed')->count();
        $totalTicketsOpen = Ticket::where('status', 'open')->count();
        $totalTicketsInProgress = Ticket::where('status', 'in_progress')->count();
		$totalTickets = Ticket::count();

		return Inertia::render('Dashboard', [
            'totalUsers' => $totalUsers,
            'totalCategories' => $totalCategories,
            'totalTickets' => $totalTickets,
            'totalTicketsSolved' => $totalTicketsSolved,
            'totalTicketsOpen' => $totalTicketsOpen,
            'totalTicketsInProgress' => $totalTicketsInProgress,
        ]);
	}
}
