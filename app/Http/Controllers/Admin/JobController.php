<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\PaigQueue;
use App\Services\PaigAPI;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class JobController extends Controller
{
    public function __construct()
    {
//        $this->middleware('auth');
    }

    public function viewJobs(){
        return view("dashboard.job.index");
    }

    public function runLocationListingJobs(){
        dispatch(new PaigQueue());
        Session::flash('message', 'The Job has been processing!');
        return redirect()->back();
    }

    public function testSingleJob(Request $request){
        $key=intval($request->get("page_number"));
        $api=app(PaigAPI::class);
        set_time_limit(240);
        $response=$api->getServerAPI($key);
        $api->setDB($response);
        dd($response);
    }
}
