<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\sensor;

class addDeviceController extends Controller
{
    public function post(Request $request){
        $p = strlen($request->kode);
        if($p != 8){
            session()->flash('error','kode alat harus 8 angka');
            return redirect()->route('adddevice');
        }

        $this->validate($request, [
            
            'kode' => 'required|string', 
          
        ]);

        $cek = sensor::where('id',$request->kode)->first();
        if($cek != NULL)
        {
            session()->flash('error','Kode alat sudah ada');
            return redirect()->route('adddevice');
        }
        else{
            $post = sensor::create([
                'id' => $request->kode,
                'status'=> 'berhasil ditambah'
            ]);

            session()->flash('message','alat ditambahkan');
            return redirect()->route('device');
        }
        

    }
    
    public function index(){

        return view('addDevice');
    }

    public function list(){
        $sensor = sensor::all();
        return view('listAlat',['key' =>$sensor]);
    }
}
