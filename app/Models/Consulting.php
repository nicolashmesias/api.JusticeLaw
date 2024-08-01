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

}
