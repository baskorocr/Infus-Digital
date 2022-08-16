<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\sensor;

class addDeviceController extends Controller
{
    public function post(Request $request){
        $p = strlen($request->kode);
        if($p != 8){
            session()->flash('message','kode alat harus 8 angka');
            return redirect()->route('device');
        }

        $this->validate($request, [
            
            'kode' => 'required|string', 
          
        ]);

        $cek = sensor::where('id',$request->kode)->first();
        if($cek != NULL)
        {
            session()->flash('message','Kode alat sudah ada');
            return redirect()->route('device');
        }
        else{
            $post = sensor::create([
                'id' => $request->kode,
                'tpm' => 0,
                'kapasitas' => 0,
                'prediksi' => 0
    
            ]);

            session()->flash('message','alat ditambahkan');
            return redirect()->route('device');
        }
        

    }
    
    public function index(){

        return view('addDevice');
    }
}
