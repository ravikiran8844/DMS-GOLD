<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */

    protected $commands = [
        Commands\Products::class,
        Commands\Category::class,
        Commands\Subcategory::class,
        Commands\Collection::class,
        Commands\subcollection::class,
        Commands\Style::class
    ];
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('upload:product')
        //     ->everyMinute()
        //     ->appendOutputTo(storage_path('logs/upload_product.log')); // Specify the log file
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
