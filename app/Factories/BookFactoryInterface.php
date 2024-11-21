<?php

namespace App\Factories;

interface BookFactoryInterface
{
    public function createBook(string $title, string $author);
}