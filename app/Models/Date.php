<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Date extends Model
{
    use HasFactory;
    protected $fillable = [
        'date',
        'state',
        'startTime',
        'endTime'
    ];


    public function lawyers(){
        return $this->belongsToMany(Lawyer::class);
    }
}
