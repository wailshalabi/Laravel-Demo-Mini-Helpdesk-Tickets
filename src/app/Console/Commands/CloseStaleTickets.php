<?php

namespace App\Console\Commands;

use App\Models\Ticket;
use Illuminate\Console\Command;

class CloseStaleTickets extends Command
{
    protected $signature = 'tickets:close-stale';
    protected $description = 'Close open tickets older than 30 days (demo scheduled task)';

    public function handle(): int
    {
        $count = Ticket::query()
            ->where('status', 'open')
            ->where('created_at', '<', now()->subDays(30))
            ->update(['status' => 'closed']);

        $this->info("Closed {$count} stale tickets.");
        return self::SUCCESS;
    }
}
