{{-- @extends('layouts.app')

@section('content')
    <h1>{{ $book->title }}</h1>
    <p>Author: {{ $book->author }}</p>

    <!-- Display Book Rating -->
    <p>Rating: 
        @for ($i = 1; $i <= 5; $i++)
            <i class="fa{{ $i <= $book->rating ? 's' : 'r' }} fa-star"></i>
        @endfor
        / 5
    </p>

    <h3>Comments</h3>
    <ul class="list-group mb-4">
        @foreach ($comments as $comment)
            <li class="list-group-item">
                <strong>{{ $comment->commenter_name }}:</strong> {{ $comment->comment }}
            </li>
        @endforeach
    </ul>

    @auth
        <!-- Rating Form -->
        <h4>Rate this book:</h4>
        <form method="POST" action="{{ route('books.rate', $book) }}">
            @csrf
            <div class="rating">
                <input type="radio" name="rating" value="1" id="star1" {{ $book->rating == 1 ? 'checked' : '' }}>
                <label for="star1"></label>

                <input type="radio" name="rating" value="2" id="star2" {{ $book->rating == 2 ? 'checked' : '' }}>
                <label for="star2"></label>

                <input type="radio" name="rating" value="3" id="star3" {{ $book->rating == 3 ? 'checked' : '' }}>
                <label for="star3"></label>

                <input type="radio" name="rating" value="4" id="star4" {{ $book->rating == 4 ? 'checked' : '' }}>
                <label for="star4"></label>

                <input type="radio" name="rating" value="5" id="star5" {{ $book->rating == 5 ? 'checked' : '' }}>
                <label for="star5"></label>
            </div>
            <button type="submit" class="btn btn-primary mt-2">Submit Rating</button>
        </form>

        <!-- Comment Form -->
        <form method="POST" action="{{ route('books.comment', $book) }}">
            @csrf
            <input type="hidden" name="book_id" value="{{ $book->id }}">
            <input type="hidden" name="user_id" value="{{ auth()->id() }}">
            <textarea name="comment" class="form-control mb-2" placeholder="Leave a comment"></textarea>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    @else
        <p><a href="{{ route('login') }}">Login</a> to leave a comment and rate the book.</p>
    @endauth

    <!-- Back Button -->
    <a href="{{ route('books.index') }}" class="btn btn-secondary mt-3">Back to Book</a>
@endsection

@section('styles')
    <style>
        .rating {
            display: flex;
            direction: row;
        }
        .rating input {
            display: none;
        }
        .rating label {
            width: 40px;
            height: 40px;
            background: url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/svgs/solid/star.svg') no-repeat center;
            background-size: contain;
            cursor: pointer;
        }

        /* Fill stars when clicked or hovered */
        .rating input:checked ~ label,
        .rating label:hover,
        .rating label:hover ~ label {
            background-color: gold;
        }

        /* Optional: Style to show filled stars when hovered or clicked */
        .rating input:checked ~ label {
            background-color: gold !important;
        }
    </style>
@endsection --}}


@extends('layouts.app')

@section('content')

    <div class="container mt-4">
        <div class="text-right mb-3">
            <a href="{{ route('books.index') }}" class="btn btn-secondary">Back to Book List</a>
        </div>
        <div class="book-details text-center mb-4">
            <h1>{{ $book->title }}</h1>
            <p><strong>Author:</strong> {{ $book->author }}</p>
            <p>
                <strong>Average Rating:</strong> {{ round($averageRating, 1) }} / 5
            </p>
        </div>

        <div class="comments-section mb-5">
            <h3>Comments</h3>
            @if ($comments->isEmpty())
                <p class="text-muted">No comments yet. Be the first to leave a comment!</p>
            @else
                <ul class="list-group">
                    @foreach ($comments as $comment)
                        <li class="list-group-item">
                            <strong>{{ $comment->commenter_name }}:</strong>
                            <p>{{ $comment->comment }}</p>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

        @auth
            <!-- Rating Form -->
            <h4>Rate this Book</h4>
            <form method="POST" action="{{ route('books.rate', $book) }}">
                @csrf
                <div class="rating mt-2 mb-4" id="rating">
                    @for ($i = 1; $i <= 5; $i++)
                        <span class="fa fa-star" data-index="{{ $i }}" style="color: lightgray;"></span>
                    @endfor
                </div>
                <input type="hidden" id="rating-value" name="rating" value="">
                <button type="submit" class="btn btn-primary">Submit Rating</button>
            </form>

            <!-- Comment Form -->
            <h4 class="mt-2">Leave a Comment</h4>
            <form method="POST" action="{{ route('books.comment', $book) }}">
                @csrf
                <textarea name="comment" class="form-control mb-3" placeholder="Write your comment here"></textarea>
                <button type="submit" class="btn btn-primary">Submit Comment</button>
            </form>
        @else
            <p class="mt-4">
                <a href="{{ route('login') }}">Login</a> to leave a comment or rate this book.
            </p>
        @endauth

    </div>
@endsection

@section('styles')
    <style>
        .rating {
            display: flex;
            justify-content: center;
            gap: 5px;
        }

        .rating .fa-star {
            font-size: 30px;
            cursor: pointer;
            transition: color 0.2s ease-in-out;
        }

        .list-group-item {
            margin-bottom: 10px;
            border-radius: 8px;
            background-color: #f9f9f9;
            padding: 15px;
        }

        .list-group-item strong {
            font-size: 16px;
        }
    </style>
@endsection

@section('scripts')
    <script>
        const stars = document.querySelectorAll('#rating .fa-star');
        const ratingValueInput = document.getElementById('rating-value');
        let currentRating = 0;

        stars.forEach(star => {
            star.addEventListener('mouseover', () => {
                const index = parseInt(star.getAttribute('data-index'));
                highlightStars(index);
            });

            star.addEventListener('mouseout', () => {
                highlightStars(currentRating);
            });

            star.addEventListener('click', () => {
                currentRating = parseInt(star.getAttribute('data-index'));
                ratingValueInput.value = currentRating;
                highlightStars(currentRating);
            });
        });

        function highlightStars(rating) {
            stars.forEach(star => {
                const index = parseInt(star.getAttribute('data-index'));
                star.style.color = index <= rating ? 'orange' : 'lightgray';
            });
        }

        highlightStars(currentRating);
    </script>
@endsection
