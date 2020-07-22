<?php

namespace App\Jobs;
use App\Services\PaigAPI;

class PaigAPIJob extends Job
{
    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 5;

    private $page_number;

    /**
     * Create a new job instance.
     *
     * @param $i
     */
    public function __construct($i)
    {
        //
        $this->page_number=$i;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        $paig=app(PaigAPI::class);
        $paig->getPropertyListings($this->page_number);
    }
}
