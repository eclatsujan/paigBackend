<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Services\PaigAPI;
use \Illuminate\Http\Request;
use \Illuminate\Support\Facades\DB;
use App\Services\PropertyDBService;

class APIController extends Controller
{
    private $paig_api;
    private $table;
    private $propertyDB;
    public function __construct(){
        $this->paig_api=app(PaigAPI::class);
        $this->propertyDB=app(PropertyDBService::class);
    }

    public function getAllListings(Request $request){

        return response()->json($this->propertyDB->getPropertiesFromDB($request),200);
    }

    public function getB2BPartners(){
        return response()->json($this->propertyDB->getB2BPartners(),200);
    }

    public function getInitialData(){
        return response()->json($this->propertyDB->getInitialData(),200);
    }

    public function singleDetail($display_id){
        $single_property=$this->propertyDB->getSingleProperty($display_id);
        if($single_property){
            return response()->json($single_property,200);
        }
        else{
            return response()->json("No property found",404);
        }
    }


    public function suggestKeyword(Request $request){
        $search_term = $request->get('search_term');
        $state = $request->get('state');
        return response()->json($this->propertyDB->getSuggestedKeyword($search_term, $state ),200);
    }

}
