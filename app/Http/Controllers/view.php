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
       $dataSensor = sensor::with('Pasien')->get();
   
       $itemVal = [];
       $itemSensor =[];
       foreach($dataSensor as $sensor){
        $value = Value::where('alat',$sensor->id)->OrderBy('id','desc')->first();
        
        if($sensor->status == "tidak terpasang"){
            
            continue;
        }
        else{

            if($value== !null)
            {
                $itemVal [] =  $value->toArray();
                $itemSensor [] = (array) $dataSensor->toArray();
            }
            else{
                continue;
            } 

        }

      
        
    }
    
       ;

       return view('index',['key'=>$itemSensor,'val'=>$itemVal]);
      
    }

   
}
