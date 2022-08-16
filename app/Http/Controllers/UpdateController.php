<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\sensor;
use DateTime;

class UpdateController extends Controller
{
    public function update(Request $request){
        if($request->kode != "--Pilih --")
        {
            $z = sensor::where('id', $request->kode)->first();
            $z->nama = $request->nama;
            $dt = new Datetime();
            $z->updated_at = $dt->format('Y-m-d H:i:s');
            $z->update();
        }
       
        session()->flash('message','Data alat sudah diupdate');
        return redirect()->route('index');

    }
}
