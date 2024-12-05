<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    
    public $fillable = ['affair', 'content', 'forum_category_id', 'user_id', 'date_publication', 'likes', // Habilitar likes
    'dislikes'];


    public function forumCategory(){
        return $this->belongsTo('App\Models\ForumCategory');
    }
    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function answers(){
        return $this->hasMany('App\Models\Answer');
    }

    public function consultings()
    {
        return $this->hasMany(Consulting::class, 'question_id');
    }


    public function likes()
    {
        return $this->hasMany(Like::class);
    }
}
