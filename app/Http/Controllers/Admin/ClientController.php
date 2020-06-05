<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class ClientController extends Controller
{

    public function __construct(){

    }

    //
    public function viewClients(){
        return view("dashboard.clients.list");
    }
}
