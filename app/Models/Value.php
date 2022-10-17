<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Value extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'alat',
        'tpm',
        'kapasitas',
        'prediksi',
        ];

        public function Pasien(){
            return $this->hasMany(Pasien::class,'id','idPasien');
        }   
         
       
}
