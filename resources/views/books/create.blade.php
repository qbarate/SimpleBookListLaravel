@extends('layouts.app')

@section('title', 'My Home')

@section('subtitle', 'Create Book')

@section('content')

@include('includes/errors')
{{ Form::open(['route' => 'store-book']) }}
    <div class="form-group">
        {{ Form::text('bookName', null, ['class' => 'form-control', 'placeholder' => 'Book title']) }}
    </div>
    <div class="form-group">
        {{ Form::text('authorName', null, ['class' => 'form-control', 'placeholder' => 'Author name']) }}
    </div>
    {{ Form::submit('Submit', ['class' => 'btn btn-primary mx-1']) }}
    @include('includes/buttons/cancel')
{{ Form::close() }}
@endsection
