@extends('layouts.app')

@section('title', 'My Home')

@section('subtitle', 'Create Book')

@section('content')

@include('includes/errors')
<form action="/books" method="POST">
    @csrf
    <div class="form-group">
        <input type="text" class="form-control" id="bookName" name="bookName" required placeholder="Book title" value="">
    </div>
    <div class="form-group">
        <input type="text" class="form-control" id="authorName" name="authorName" required placeholder="Author name" value="">
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
</form>
@endsection
