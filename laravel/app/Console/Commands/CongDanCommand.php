<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CongDanCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cong-dan:check-dktt';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checked and sent the Email for CongDan-DKTT';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->call('\App\Http\Controllers\Admin\CongDanController@sendmail');
        $this->info('CongDan-DKTT has been checked!');
    }
}
