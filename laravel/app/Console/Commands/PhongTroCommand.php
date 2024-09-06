<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Carbon\Carbon;

class PhongTroCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'phong-tro:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new phong_tro';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $rs = DB::table('phong_tros')->insert([
            'name' => 'Phong tro '.Carbon::now()->format('His'),
            'status' => 'active',
            'created_by' => 1,
            'modified_by' => 1,
            'created' => Carbon::now(),
            'modified' => Carbon::now()
        ]);
        echo $rs."\n";
    }
}
