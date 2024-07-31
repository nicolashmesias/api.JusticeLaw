<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    public $fillable =[
        'affair',
        'content',
        'date_publication',
        'user_id',
        'forum_category_id'
    ];
    public function forumCategories(){
        return $this->belongsTo('App\Models\ForumCategory');
    }
    public function users(){
        return $this->belongsTo('App\Models\User');
    }

}
