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
        $str = 'some string';
        $result = '';
        if (Cache::has('my_string')) {
            $result = Cache::get('my_string');
        } else {
            Cache::put('my_string', $str);
            $result = $str;
        }
        dd($result);
    }
}
