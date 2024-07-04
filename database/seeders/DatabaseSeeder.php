<?php

namespace Database\Seeders;

use App\Models\ChatMessage;
use App\Models\ChatRoom;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UsersTableSeeder::class,
            CategoriesTableSeeder::class,
            ArticleSeeder::class,
            TicketsTableSeeder::class,
            CommentSeeder::class,
            AttachmentSeeder::class,
            ChatRoomSeeder::class,
            ChatMessageSeeder::class,
        ]);
        User::factory()->create([
            'name' => 'Test Admin',
            'email' => 'admin@admin.com',
            'is_admin' => true
        ]);
        User::factory()->create([
            'name' => 'Test user',
            'email' => 'user@user.com',
            'is_admin' => false
        ]);
        
    }
}
