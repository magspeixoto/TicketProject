<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ChatRoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure there are users to associate chat rooms with
        $users = User::all();

        if ($users->isEmpty()) {
            // Optionally create users if none exist
            User::factory(10)->create();
            $users = User::all();
        }

        // Create chat rooms for some users
        foreach ($users as $user) {
            DB::table('chat_rooms')->insert([
                'user_id' => $user->id,
                'identifier' => Str::uuid(),
                'is_closed' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
