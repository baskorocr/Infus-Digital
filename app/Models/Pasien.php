<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'alat',
        'nama',
        'ruang',
        ];

        public function sensor(){
            return $this->hasOne(sensor::class,'alat','id');
        }   
        
        

}
