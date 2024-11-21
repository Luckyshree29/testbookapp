<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['user_id', 'book_id', 'content', 'commenter_name'];
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

}
