<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <title>YarakuTest</title>

        <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.16.0/dist/bootstrap-table.min.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

        <link rel="stylesheet" href="{{URL::asset('/css/bookList.css')}}"/>
    </head>
    <body>
        <!-- Book list table -->
        <div class="container">
            <h1>Welcome to the book list</h1>

            @if ($errors->any())
            <div class="alert alert-danger" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <a class="mx-1" href="/Book/Create"><button type="button" class="btn btn-primary">Create Book</button></a> <!-- TODOQBA <a> is probably not necessary -->
            <button type="button" class="btn btn-info mx-1" data-toggle="modal" data-target="#exportModal">Export...</button>

            <table id="bookList"></table>
        </div>

        <!-- Export modal -->
        <div class="modal fade" id="exportModal" tabindex="-1" role="dialog" aria-labelledby="exportModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exportModalLabel">Export data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="fieldsToExport">
                        <input type="checkbox" id="BookNameExport" name="BookName" value="BookName" checked/>
                        <label for="BookNameExport">Title</label><br>
                        <input type="checkbox" id="AuthorNameExport" name="AuthorName" value="AuthorName" checked/>
                        <label for="AuthorNameExport">Author</label><br>
                        <a id="downloadExport" download="" href=”” style="display: none;"></a>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" onCLick="exportCSV()">Export CSV</button>
                        <button type="button" class="btn btn-primary" onCLick="exportXML('Book')">Export XML</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Confirm delete modal -->
        <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
            <form action="/Book/Delete" method="POST">
                @csrf
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmation</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                        <p>Do you really want to delete <span style="font-weight: bold;" id="bookNameToDelete"></span> ?</p>

                        <input type="hidden" id="bookIdToDelete" name="bookId" value=""/>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <script
			  src="https://code.jquery.com/jquery-3.4.1.min.js"
			  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
              crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
        <script src="https://unpkg.com/bootstrap-table@1.16.0/dist/bootstrap-table.min.js"></script>
        <script>
            // We setup a few variables using blade here since blad will be unavailable in a separate .js file.
            var binUrl = "{{URL::asset('/icons/trash-alt-solid.svg')}}";
            var penUrl = "{{URL::asset('/icons/pen-solid.svg')}}";
        </script>
        <script src="{{URL::asset('/bookList.js')}}"></script> <!-- TODO: Move the js to its appropriate place -->
    </body>
    <!-- Icons: https://fontawesome.com/license -->
</html>

