<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\sensor;
use App\Models\Pasien;
use DateTime;

class UpdateController extends Controller
{
    public function update(Request $request){
        if($request->kode != "--Pilih --")
        {
            
            
            $z = sensor::where('id', $request->kode)->first();
            Pasien::Create([
                
                'alat'=> $z->id,
                'nama'=>$request->nama,
                'ruang'=>$request->ruang
            ]);

            session()->flash('message','Data alat sudah diupdate');
            return redirect()->route('index');

        }
        else{
            session()->flash('error','kode alat belum dipilih');
            return redirect()->route('index');

        }

        
       
        
    }

    public function delete($id){
        $sensor = sensor::find($id)->first();
        $sensor -> delete();
        return redirect()->route('device');


    }

    public function index(){
        $sensor = sensor::all();
        return view('updates',['key' =>$sensor]);

    }
}
