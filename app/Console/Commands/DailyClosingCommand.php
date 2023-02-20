<?php

namespace App\Console\Commands;

use App\Http\Controllers\SalesController;
use Illuminate\Console\Command;

class DailyClosingCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'batch:closing';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        SalesController::storeDailySales();
    }
}
