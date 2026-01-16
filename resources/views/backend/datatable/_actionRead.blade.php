<form action="{{ $read_url }}" method="post">
    @csrf
    <button type="submit" class="btn btn-success act-btn" value="delete" data-toggle="tooltip" title="Read">
        <span class="fas fa-search"></span>
    </button>
</form>