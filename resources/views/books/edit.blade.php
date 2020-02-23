@extends('layouts.app')

@section('title', 'My Home')

@section('subtitle', 'Edit Book')

@section('content')

@include('includes/errors')

{{ Form::open(['route' => ['update-book', $book->Id]]) }}
    <div class="form-group">
        {{ Form::text('bookName', $book->Name, ['class' => 'form-control', 'placeholder' => 'Book title']) }}
    </div>
    <div class="form-group">
        {{ Form::text('authorName', $author->Name, ['class' => 'form-control', 'placeholder' => 'Author name']) }}
    </div>

    {{ Form::submit('Submit', ['class' => 'btn btn-primary mx-1']) }}
    @include('includes/buttons/cancel')
{{ Form::close() }}
@endsection
