<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    // Define the table if it's not named 'ratings'
    protected $table = 'ratings';

    // The columns you want to fill
    protected $fillable = [
        'book_id', 'user_id', 'rating', 
    ];

    // Set up the relationship with the Book model
    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
