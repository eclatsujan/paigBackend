<?php


namespace App\Jobs;


use App\Services\PaigAPI;
use App\Services\PropertyDBService;

class PaigAddressJob extends Job
{
    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 5;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        $this->recursiveQueue();
    }

    public function recursiveQueue(){

    }
}
