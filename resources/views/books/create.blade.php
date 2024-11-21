@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="text-right mb-3">
        <a href="{{ route('books.index') }}" class="btn btn-secondary">Back to Book List</a>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h1 class="text-center mb-4">Add a New Book</h1>

            <form action="{{ route('books.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="title" class="form-label fs-5">Title</label>
                    <input type="text" name="title" id="title" class="form-control form-control-lg" required>
                </div>

                <div class="mb-4">
                    <label for="author" class="form-label fs-5">Author</label>
                    <input type="text" name="author" id="author" class="form-control form-control-lg" required>
                </div>

                <button type="submit" class="btn btn-primary btn-lg w-100">Add Book</button>
            </form>

           
        </div>
    </div>
</div>
@endsection
