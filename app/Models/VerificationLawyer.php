<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerificationLawyer extends Model
{
    use HasFactory;

    public function country(){
        return $this->belongsTo(Country::class);
    }

    public function lawyer(){
        return $this->belongsTo(Lawyer::class);
    }

    public function state(){
        return $this->belongsTo(State::class);
    }

    public function city(){
        return $this->belongsTo(City::class);
    }
    
}
