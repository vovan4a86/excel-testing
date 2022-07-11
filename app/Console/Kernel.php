<?php namespace App\Console;

use Fanky\Admin\Controllers\AdminParserController;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Fanky\Crm\Models\Task;
use Fanky\Crm\Mailer;
use DB;

class Kernel extends ConsoleKernel {

    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\ImportOld::class,
        Commands\Test::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule) {

//			$schedule->call(function () {
//				$controller = new AdminParserController();
//				$controller->main();
//			})->everyMinute();

//		$schedule->command('queue:work --daemon')->everyMinute()->withoutOverlapping()
//			->sendOutputTo(storage_path() . '/logs/queue-jobs.log');
    }
    //в крон прописать - php artisan schedule:run
}
