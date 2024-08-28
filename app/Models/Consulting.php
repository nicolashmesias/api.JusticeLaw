<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consulting extends Model
{
    use HasFactory;
    protected $fillable = [
        'date',
        'time',
        'price',
        'answer_id',
        'question_id',
    ];

    public function answer()
    {
        return $this->belongsTo(Answer::class, 'answer_id');
    }

    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }

}
