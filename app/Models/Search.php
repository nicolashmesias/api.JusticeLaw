<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Search extends Model
{
    use HasFactory;
    protected $fillable = [
        'fecha',
        'user_id',
        'lawyer_id',
        'information_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

   
    public function lawyer()
    {
        return $this->belongsTo(Lawyer::class);
    }


    public function information()
    {
        return $this->belongsTo(Information::class);
    }

}
