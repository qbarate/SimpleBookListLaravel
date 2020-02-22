@extends('layouts.app')

@section('title', 'My Home')

@section('subtitle', 'Edit Book')

@section('content')

@include('includes/errors')
<form action="/books/{{ $book->Id }}/update" method="POST">
    @csrf
    <div class="form-group">
        <input type="text" class="form-control" id="bookName" name="bookName" required placeholder="Book title" value="{{ $book->Name ?? '' }}">
    </div>
    <div class="form-group">
        <input type="text" class="form-control" id="authorName" name="authorName" required placeholder="Author name" value="{{ $author->Name ?? '' }}">
    </div>

    <button type="submit" class="btn btn-primary mx-1">Submit</button>
    <a href="/"><button class="btn btn-secondary mx-1">Cancel</button></a>
</form>
@endsection
