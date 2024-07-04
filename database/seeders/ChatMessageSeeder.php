<?php

namespace Database\Seeders;

use App\Models\ChatRoom;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChatMessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $chatRooms = ChatRoom::all();
        $users = User::all();

        if ($chatRooms->isEmpty() || $users->isEmpty()) {
            // Optionally create chat rooms and users if none exist
            User::factory(10)->create();
            ChatRoom::factory(5)->create();
            $chatRooms = ChatRoom::all();
            $users = User::all();
        }

        foreach ($chatRooms as $chatRoom) {
            for ($i = 0; $i < 10; $i++) {
                DB::table('chat_messages')->insert([
                    'chat_room_id' => $chatRoom->id,
                    'user_id' => $users->random()->id,
                    'message' => 'This is a sample message for chat room ' . $chatRoom->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
