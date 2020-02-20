@extends('layouts.app')

@section('title', 'My Home')

@section('subtitle', 'Book list')

@section('content')

@include('includes/errors')

<div>
    <a class="mx-1" href="/books/create"><button type="button" class="btn btn-primary">Create Book</button></a>
    <button type="button" class="btn btn-info mx-1" data-toggle="modal" data-target="#exportModal">Export...</button>
</div>

<table id="bookList"></table>

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
                <button type="button" class="btn btn-primary" onCLick="exportCSV()">Generate CSV</button>
                <button type="button" class="btn btn-primary" onCLick="exportXML('Book')">Generate XML</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Confirm delete modal -->
<!-- TODOQBA: to refactor -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <form action="/books/delete" method="POST">
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

@endsection

@section('js')
@parent
<script src="https://unpkg.com/bootstrap-table@1.16.0/dist/bootstrap-table.min.js"></script>
        <script>
            // We setup a few variables using blade here since blad will be unavailable in a separate .js file.
            var binUrl = "{{URL::asset('/icons/trash-alt-solid.svg')}}";
            var penUrl = "{{URL::asset('/icons/pen-solid.svg')}}";
        </script>
        <script src="{{URL::asset('/bookList.js')}}"></script>
@endsection