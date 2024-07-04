<?php

namespace Database\Factories;

use App\Models\Attachment;
use App\Models\Comment;
use App\Models\Ticket;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Attachment>
 */
class AttachmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Attachment::class;
    public function definition(): array
    {
        return [
            'file_path' => $this->faker->filePath(),
            'ticket_id' => Ticket::inRandomOrder()->first()->id,
            'comment_id' => Comment::inRandomOrder()->first()->id,
        ];
    }
}
