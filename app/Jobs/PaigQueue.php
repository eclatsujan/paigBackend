<?php
namespace App\Jobs;


use App\Services\PaigAPI;

class PaigQueue extends Job
{
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try{
            $paig=app(PaigAPI::class);
            $res=$paig->getPropertyListings(1);
            for($i=0;$i<$res["page_total"];$i++){
                dispatch(new PaigAPIJob($i));
            }
        }
        catch(\Exception $e){

        }


    }
}
