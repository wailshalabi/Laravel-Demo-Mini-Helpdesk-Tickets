<?php

namespace App\Console;

use App\Console\Commands\CloseStaleTickets;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        CloseStaleTickets::class,
    ];

    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('tickets:close-stale')->daily();
    }
}
