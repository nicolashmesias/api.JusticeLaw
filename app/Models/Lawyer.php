<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Lawyer as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Lawyer extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];


    const REGISTRO_CIVIL_DE_NACIMIENTO = 1;
    const TARJETA_DE_IDENTIDAD = 2;
    const TARJETA_EXTRANJERIA = 3;
    const CEDULA_CIUDADANIA = 4;
    const NIT = 5;
    const PASAPORTE = 6;

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function typeDocument(){
        return $this->belongsTo(TypeDocument::class);
    }

    public function lawyerProfile(){
        return $this->hasOne(LawyerProfile::class);
    }

    public function verificationLawyer(){
        return $this->hasOne(VerificationLawyer::class);
    }

    public function answers(){
        return $this->hasMany(Answer::class);
    }

    public function notifications(){
        return $this->hasMany(Notification::class);
    }

    public function searches(){
        return $this->hasMany(Search::class);
    }

    public function reviews(){
        return $this->hasMany(Review::class);
    }

    public function areas()
    {
        return $this->belongsToMany(Area::class, 'area_lawyers', 'lawyer_id', 'area_id');
    }

    public function verification()
    {
        return $this->hasOne(VerificationLawyer::class);
    }

    public function dates(){
        return $this->belongsToMany(Date::class);
    }
}
