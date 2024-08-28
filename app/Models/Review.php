<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    protected $fillable = [
        'content',
        'date',
        'user_id',
        'lawyer_id'
    ];

    public function lawyer(){
        return $this->belongsTo(Lawyer::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function overhaulReviews()
    {
        return $this->hasMany(OverhaulReview::class, 'review_id');
    }

}
