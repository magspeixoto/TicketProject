<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserManagementController extends Controller
{
    public function index()
    {
        $users = User::all();

        return Inertia::render('UsersManagement/Index', [
            'users' => $users,

        ]);
    }
    public function create()
    {
        return inertia(
            'UsersManagement/Create',
        );
    }

    public function store(Request $request)
    {
        User::create(
            $request->validate([
                'name' => 'required',
                'email' => 'required',
            ])
        );

        return redirect()->route('usersManagement.index');
    }

    public function edit(User $user)
    {
        return inertia('UsersManagement/Edit', [
            'user' => $user
        ]);
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'role' => 'required|string|max:255', // Assuming 'role' is also required
        ]);

        $user->update($request->only('name', 'email', 'role'));

        return redirect()->route('usersManagement.index');
    }

    public function destroy(User $user)
    {
        $user->delete();

        // Redirect to the same (or previous) page with a flash message
        return redirect()->route('usersManagement.index');
    }
}
