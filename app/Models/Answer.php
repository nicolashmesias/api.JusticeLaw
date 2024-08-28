<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    public $fillable=[
        'affair',
        'content',
        'date_publication',
        'lawyer_id',
        'question_id'
    ];

    public function question(){
        return $this->belongsTo(Question::class);
    }

    public function lawyer(){
        return $this->belongsTo(Lawyer::class);
    }

    public function consultings()
    {
        return $this->hasMany(Consulting::class, 'answer_id');
    }
}
