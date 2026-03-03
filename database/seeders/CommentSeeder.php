<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    public function run(): void
    {
        $users   = User::all();
        $tickets = Ticket::all();

        if ($users->isEmpty() || $tickets->isEmpty()) {
            $this->command->warn('Geen users of tickets gevonden. Seed die eerst.');
            return;
        }

        foreach ($tickets as $ticket) {
            // Elke ticket krijgt 1–4 willekeurige reacties
            $count = rand(1, 4);
            for ($i = 0; $i < $count; $i++) {
                Comment::create([
                    'ticket_id' => $ticket->id,
                    'user_id'   => $users->random()->id,
                    'body'      => fake()->sentence(),
                ]);
            }
        }

        $this->command->info('Comments succesvol geseeded!');
    }
}
