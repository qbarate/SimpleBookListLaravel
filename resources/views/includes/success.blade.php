@isset ($success)
<div class="alert alert-primary alert-dismissible fade show" role="alert">
    {{ $success }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endisset