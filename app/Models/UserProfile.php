<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'cell_phone', 'country_id','state_id', 'city_id','profile_photo', 'user_id'
    ];


    public function user(){
        return $this->belongsTo(User::class);
    }

    public function state(){
        return $this->belongsTo(State::class);
    }

    public function city(){
        return $this->belongsTo(City::class);
    }

    public function country(){
        return $this->belongsTo(Country::class);
    }


}
