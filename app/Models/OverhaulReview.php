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

    public function review()
    {
        return $this->belongsTo(Review::class, 'review_id');
    }

    public function administrator()
    {
        return $this->belongsTo(Administrator::class, 'administrators_id');
    }

}
