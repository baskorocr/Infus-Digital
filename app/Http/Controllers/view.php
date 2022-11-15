<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use App\Models\Value;
use App\Models\Pasien;
use App\Models\sensor;

class view extends Controller
{
  
    public function sensor($temp){
        // $pasien = Pasien::where('alat', $alat)->where('status','1')->get();
        $kapasitas ; //kapasitas dari alat
        $prediksi = $kapasitas/$temp;
        Value::Create([
                
            'idPasien'=> "2",
            'tpm'=> $temp,
            'kapasitas'=> "0",
            'prediksi'=> "0",
            
        ]);

    }

    
   
    public function index()
    {
       
       $Tempdata = Pasien::with('sensor.Value')->get();
       $Tempvalue = Value::get();
       
       $data = $Tempdata->toArray();
       $value = $Tempvalue->toArray();
   
       
  
       if(count($Tempdata) == !0 ){
        return view('index',['data'=>$data],['value'=>$value]);
       }
       else{
        dd("dsadsa");
       }
      
    }

   
}
