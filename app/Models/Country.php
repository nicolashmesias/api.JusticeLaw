<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'phonecode',
    ];

    public function users(){
        return $this->hasMany(User::class);
    }

    public function states(){
        return $this->hasMany(State::class);
    }

    public function verificationLawyers()
    {
        return $this->hasMany(VerificationLawyer::class);
    }
}
