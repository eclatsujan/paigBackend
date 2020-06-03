<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\PaigQueue;

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
        return redirect()->back();
    }
}
