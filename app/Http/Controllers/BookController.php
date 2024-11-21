<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Factories\BookFactoryInterface;

class BookController extends Controller
{
    
    // protected $bookFactory;

    // public function __construct(BookFactoryInterface $bookFactory)
    // {
    //     $this->bookFactory = $bookFactory;
    // }
    public function create()
    {
        return view('books.create');
    }

    // Store the new book in the database
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255'
        ]);

        Book::create([
            'title' => $request->title,
            'author' => $request->author
        ]);

        return redirect()->route('books.index')->with('success', 'Book added successfully!');
    }

    // public function store(Request $request)
    // {
    //     $book = $this->bookFactory->createBook($request->title, $request->author);
    //     $book->save();

    //     return redirect()->route('books.index');
    // }
    // public function index(Request $request)
    // {
    //     $query = Book::query();

    //     if ($request->has('search')) {
    //         $query->where('title', 'like', '%' . $request->search . '%')
    //               ->orWhere('author', 'like', '%' . $request->search . '%');
    //     }

    //     $books = $query->paginate(10);
    //     return view('books.index', compact('books'));
    // }
    public function index(Request $request)
{
    $search = $request->get('search');

    $books = Book::with('ratings') // Eager load ratings relationship
        ->when($search, function($query) use ($search) {
            $query->where('title', 'like', '%' . $search . '%')
                ->orWhere('author', 'like', '%' . $search . '%');
        })
        ->paginate(10); // Paginate the result with 10 books per page

    // Calculate the average rating for each book
    foreach ($books as $book) {
        $book->average_rating = $book->ratings->avg('rating');
    }

    return view('books.index', compact('books'));
}
    
    public function show(Book $book)
    {
        // Calculate average rating
        $averageRating = $book->ratings()->avg('rating');
        
        // Fetch comments
        $comments = $book->comments;
    
        // Pass the average rating and comments to the view
        return view('books.show', [
            'book' => $book,
            'averageRating' => round($averageRating, 1), // Round to one decimal place
            'comments' => $comments
        ]);
    }    

    public function storeComment(Request $request, Book $book)
    {
        // Validate the comment input
        $request->validate([
            'comment' => 'required|string|max:1000', // Adjust validation as needed
        ]);

        // Store the comment with user_id, book_id, and commenter_name
        $comment = new Comment();
        $comment->user_id = auth()->id(); // Get the authenticated user's id
        $comment->book_id = $book->id; // Set the book id
        $comment->comment = $request->comment; // Store the comment text
        $comment->commenter_name = auth()->user()->name; // Store the user's name

        // Save the comment to the database
        $comment->save();

        // Redirect back to the book details page with a success message
        return redirect()->route('books.show', $book)->with('success', 'Comment added successfully!');
    }
    public function rate(Request $request, Book $book)
    {
        // Validate the rating (ensure it's between 1 and 5)
        $request->validate([
            'rating' => 'required|integer|between:1,5',
        ]);
        // Create the rating for the book
        $book->ratings()->create([
            'user_id' => auth()->id(), // Use the authenticated user's ID
            'rating' => $request->input('rating'),
        ]);

        return redirect()->route('books.show', $book)->with('success', 'Rating submitted successfully!');
    }
}
