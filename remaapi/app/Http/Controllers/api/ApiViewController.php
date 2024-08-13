<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order;
use App\OrderItems;
use App\ShopCon;
use App\Member;
use App\ShopConspec;
use Log;
use DB;
use App\ApiConfig;

class ApiViewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   
    public function index(Request $request)
    {
        $data = ApiConfig::orderBy('id','desc')->paginate(15);
        return view("ApiView")->with('data',$data);
    }
}
