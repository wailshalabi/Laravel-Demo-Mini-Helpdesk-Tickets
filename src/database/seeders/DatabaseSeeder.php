<?php

namespace Database\Seeders;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.test',
            'role' => 'admin',
        ]);

        $agent = User::factory()->create([
            'name' => 'Agent',
            'email' => 'agent@example.test',
            'role' => 'agent',
        ]);

        $user = User::factory()->create([
            'name' => 'User',
            'email' => 'user@example.test',
            'role' => 'user',
        ]);

        Ticket::factory()
            ->count(12)
            ->for($user, 'creator')
            ->create([
                'assigned_to' => $agent->id,
            ]);
    }
}
