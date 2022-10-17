<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use App\Models\Value;
use App\Models\sensor;

class view extends Controller
{
   
    public function index()
    {
       $Tempdata = Value::with('Pasien.sensor')->get();
       $data = $Tempdata->toArray();

       if(count($Tempdata) == !0 ){
        return view('index',['data'=>$data]);
       }
       else{
        dd("dsadsa");
       }
      
    }

   
}
