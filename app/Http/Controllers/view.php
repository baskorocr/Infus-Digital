<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use App\Models\Value;
use App\Models\Pasien;
use App\Models\sensor;
use Response;

class view extends Controller
{
  
    public function sensor($idAlat, $dropsPerMinutes ,$kapasitas, $status){
        $pasien = Pasien::where('alat', $idAlat)->where('status','1')->first();
        $convert = $kapasitas *1000;
        $prediksi = ($convert/$dropsPerMinutes)/10;
        Value::Create([
                
            'idPasien'=> $pasien->id,
            'tpm'=> $dropsPerMinutes,
            'kapasitas'=> $kapasitas,
            'prediksi'=> $prediksi,
            'status' => $status
            
        ]);

    }

    public function index()
    {
       
       $Tempdata = Pasien::with('sensor.Value')->get();

       $Tempvalue = Value::get();
       
       $data = $Tempdata->toArray();
       $value = $Tempvalue->toArray();
     

       if(count($Tempdata) == !0 ){
        return view('index',['data'=>$data]);
       }
       else{
       
       }
      
    }
    public function get(){
        $Tempdata = Pasien::with('sensor.Value')->get();
       $Tempvalue = Value::get();
       $data = $Tempdata->toArray();
       $value = $Tempvalue->toArray();
   
       
  
       if(count($Tempdata) == !0 ){
        return response()->json(['value'=>$value, 'data'=>$data], 200);
       }
       else{
        dd("dsadsa");
       }
    }

   
}
