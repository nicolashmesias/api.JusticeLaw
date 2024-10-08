<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;


   protected $fillable = [
    'statement',
    'content',
       'status',
      'date',
      'lawyer_id',
];

const READ = 1 ;
const UNREAD = 2;


public function lawyer(){
    return $this->belongsTo(Lawyer::class);
}

public function user(){
    return $this->belongsTo(User::class);
}
}
