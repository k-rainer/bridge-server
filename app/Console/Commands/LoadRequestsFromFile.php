<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class LoadRequestsFromFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'requests:load';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Loads requests from file';

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
        
        $serializedRequests = file_get_contents(storage_path('app/requests.bin.gz'));
        $serializedRequests = gzuncompress($serializedRequests);
        $requests = collect(unserialize($serializedRequests));

        $requests->each(function($value, $key) {

            cache()->set($key, $value);

        });

        $this->info('requests loaded from file');

    }
}
