<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Category::create([
            'name' => 'General',
            'description' => 'General inquiries and support',
        ]);

        Category::create([
            'name' => 'Technical',
            'description' => 'Technical support and troubleshooting',
        ]);

        Category::create([
            'name' => 'Billing',
            'description' => 'Billing and account issues',
        ]);

        Category::factory()->count(5)->create();
}
}