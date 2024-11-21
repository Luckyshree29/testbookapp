{{-- @extends('layouts.app')

@section('content')
    <h1>Books</h1>

    <a href="{{ route('books.create') }}" class="btn btn-success mb-4">Add New Book</a>

    <form method="GET" class="mb-4">
        <input type="text" name="search" placeholder="Search by title or author" class="form-control" value="{{ request('search') }}">
    </form>

    <div class="row">
        @foreach ($books as $book)
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5>{{ $book->title }}</h5>
                        <p>Author: {{ $book->author }}</p>
                        <p>Rating: {{ str_repeat('★', $book->rating) }}</p>
                        <a href="{{ route('books.show', $book) }}" class="btn btn-primary">View</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{ $books->links() }}
@endsection --}}


@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Books</h1>

        <!-- Right aligned buttons -->
        <div class="d-flex gap-3">
            <form method="GET" class="d-flex">
                <input type="text" name="search" placeholder="Search by title or author" class="form-control" value="{{ request('search') }}">
            </form>
            <a href="{{ route('books.create') }}" class="btn btn-success">Add New Book</a>
        </div>
    </div>

    <div class="row">
        @foreach ($books as $book)
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5>{{ $book->title }}</h5>
                        <p>Author: {{ $book->author }}</p>
                        
                        <!-- Display the average rating -->
                        @if ($book->average_rating)
                            <p>Average Rating: {{ number_format($book->average_rating, 1) }} / 5</p>
                        @else
                            <p>No ratings yet.</p>
                        @endif

                        <!-- Right aligned View button -->
                        <div class="text-end">
                            <a href="{{ route('books.show', $book) }}" class="btn btn-primary">View</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Add pagination links -->
    {{ $books->links() }}
@endsection
