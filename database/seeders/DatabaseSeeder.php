<?php

namespace Database\Seeders;

use App\Models\ChatMessage;
use App\Models\ChatRoom;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

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
        /* // Create roles
        $administrator = Role::create(['name' => 'Administrator']);
        $manager = Role::create(['name' => 'Manager']);
        $agent = Role::create(['name' => 'Agent']);
        $customer = Role::create(['name' => 'Customer']);

        // Create permissions
        $permissions = [
            // Administrator permissions
            'create users', 'read users', 'update users', 'delete users',
            'create tickets', 'read tickets', 'update tickets', 'delete tickets',
            'manage ticket statuses', 'manage ticket priorities', 'generate reports', 'modify configurations',

            // Manager permissions
            'create tickets', 'read tickets', 'update tickets', 'close tickets',
            'assign tickets', 'view reports', 'manage ticket statuses', 'manage ticket priorities',

            // Agent permissions
            'create tickets', 'read tickets', 'update tickets', 'close tickets',
            'add comments',

            // Customer permissions
            'create tickets', 'read own tickets',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Assign permissions to roles
        $administrator->givePermissionTo(Permission::all());
        $manager->givePermissionTo([
            'create tickets', 'read tickets', 'update tickets', 'close tickets',
            'assign tickets', 'view reports', 'manage ticket statuses', 'manage ticket priorities',
        ]);
        $agent->givePermissionTo([
            'create tickets', 'read tickets', 'update tickets', 'close tickets',
            'add comments',
        ]);
        $customer->givePermissionTo([
            'create tickets', 'read own tickets', 'add comments',
        ]); */
    }
}
