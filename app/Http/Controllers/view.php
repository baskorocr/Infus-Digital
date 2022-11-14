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
        $kapasitas = 500;
        $prediksi = $kapasitas/$temp;
        $prediksi = $prediksi/60;
        Value::Create([
                
            'idPasien'=> "2",
            'tpm'=> $temp,
            'kapasitas'=> $kapasitas,
            'prediksi'=> $prediksi,
            
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
