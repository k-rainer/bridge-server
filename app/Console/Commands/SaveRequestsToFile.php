<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SaveRequestsToFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'requests:save';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Saves requests to file';

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
        
        $requests = collect();

        collect(cache()->keys('*'))
            ->each(function($key) use ($requests) {

                $requests->put($key, cache()->get($key));

            });

        $serializedRequests = serialize($requests->all());
        $serializedRequests = gzcompress($serializedRequests, 9);

        file_put_contents(storage_path('app/requests.bin.gz'), $serializedRequests);

        $this->info('requests saved to file');

    }
}
