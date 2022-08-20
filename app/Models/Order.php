<?php

namespace App\Models;

use App\Models\User;
use App\Models\ShipState;
use App\Models\ShipDistrict;
use App\Models\ShipDivision;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function division(){
    	return $this->belongsTo(ShipDivision::class,'division_id','id');
    }

      public function district(){
    	return $this->belongsTo(ShipDistrict::class,'district_id','id');
    }

      public function state(){
    	return $this->belongsTo(ShipState::class,'state_id','id');
    }

      public function user(){
    	return $this->belongsTo(User::class,'user_id','id');
    }
}
