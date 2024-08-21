<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'last_name',
        'type_document_id',
        'document_number',
        'email',
        'password',
    ];


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

    public function userProfile(){
        return $this->hasOne(UserProfile::class);
    }

    public function questions(){
        return $this->hasMany(Question::class);
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

}
