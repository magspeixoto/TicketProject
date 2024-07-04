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
		$totalTickets = Ticket::count();

		return Inertia::render('Dashboard', [
            'totalUsers' => $totalUsers,
            'totalCategories' => $totalCategories,
            'totalTickets' => $totalTickets,
        ]);
	}
}
