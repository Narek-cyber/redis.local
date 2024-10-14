<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class RedisTestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'redis:work';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Cache::put('worker', 'John');
        $str = Cache::get('worker');
        Cache::put('worker', $str . ' Doe');
//        Cache::forget('worker');
        $str = Cache::get('worker');
        dd($str);
    }
}
