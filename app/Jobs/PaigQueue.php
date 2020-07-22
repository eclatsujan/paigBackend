<?php
namespace App\Jobs;


use App\Services\PaigAPI;
use Illuminate\Support\Facades\Log;

class PaigQueue extends Job
{
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $paig=app(PaigAPI::class);
        $res=$paig->getPropertyListings(1);
        for($i=$res["page_total"];$i>=1;$i++){
            dispatch(new PaigAPIJob($i));
        }
    }
}
