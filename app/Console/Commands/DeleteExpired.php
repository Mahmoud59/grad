<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\ParkReserve;
use Carbon;

class DeleteExpired extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:deleteexpired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $mytime = Carbon\Carbon::now();
        $p = ParkReserve::where('to' , $mytime)->delete();
    }
}
