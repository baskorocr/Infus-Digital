<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\sensor;

class view extends Controller
{
    public function index()
    {
        $sensor = sensor::all();
        return view('index',['key' =>$sensor]);
        
    }
}
