<?php

namespace App\Factories;

use App\Models\Book;

class BookFactory implements BookFactoryInterface
{
    public function createBook(string $title, string $author): Book
    {
        // You can customize the logic here, e.g., setting the default rating, etc.
        return new Book([
            'title' => $title,
            'author' => $author
        ]);
    }
}