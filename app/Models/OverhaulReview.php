<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OverhaulReview extends Model
{
    use HasFactory;

    protected $fillable = [
    
        'review_id',
        'administrators_id',


    ];

}