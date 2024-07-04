<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket>
 */
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Ticket::class;
    public function definition(): array
    {
        return [
            'subject' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'category_id' => Category::inRandomOrder()->first()->id,
            'user_id' => User::where('role', 'customer')->inRandomOrder()->first()->id,
            'agent_id' => User::where('role', 'agent')->inRandomOrder()->first()->id,
            'status' => $this->faker->randomElement(['open', 'in_progress', 'closed']),
            'priority' => $this->faker->randomElement(['low', 'medium', 'high']),
        ];
    }
}
