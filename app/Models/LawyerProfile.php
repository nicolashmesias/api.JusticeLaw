<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LawyerProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'lawyer_id',
        'biography',
        'profile_photo',
    ];


    public function lawyer(){
        return $this->belongsTo(Lawyer::class);
    }
    
}
