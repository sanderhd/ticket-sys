<?php

namespace Database\Factories;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'body'      => $this->faker->sentence(),
            'user_id'   => User::inRandomOrder()->first()?->id ?? User::factory(),
            'ticket_id' => Ticket::inRandomOrder()->first()?->id ?? Ticket::factory(),
        ];
    }
}
