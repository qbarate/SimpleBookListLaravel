@extends('layouts.app')

@section('title', 'My Home')

@section('subtitle', 'Edit Book')

@section('content')

@include('includes/errors')
            <form action="/books" method="POST">
                @csrf
                <div class="form-group row">
                    <input type="text" class="form-control" id="bookName" name="bookName" required placeholder="Book title" value="{{ $book->Name ?? '' }}">
                </div>
                <div class="form-group row">
                    <input type="text" class="form-control" id="authorName" name="authorName" required placeholder="Author name" value="{{ $author->Name ?? '' }}">
                </div>

                <input type="hidden" id="bookId" name="bookId" value="{{ $book->Id ?? '' }}"/>

                <div class="row">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
@endsection
