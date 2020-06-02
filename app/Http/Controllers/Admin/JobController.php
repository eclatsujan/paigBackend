<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\PaigQueue;

class JobController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function runLocationListingJobs(){
        dispatch(new PaigQueue());
    }
}
