<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>YarakuTest</title>

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        
        <link rel="stylesheet" href="{{URL::asset('/css/bookList.css')}}"/>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <h1>Edit book</h1>
            </div>

            @if ($errors->any())
            <div class="row">
                <div class="alert alert-danger" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif

            <form action="/Book/Submit" method="POST">
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
        </div>
        <script
			  src="https://code.jquery.com/jquery-3.4.1.min.js"
			  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
              crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    </body>
</html>
