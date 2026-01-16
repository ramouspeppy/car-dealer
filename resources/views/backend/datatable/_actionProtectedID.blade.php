<ul class="list-inline m-0">
    <li class="list-inline-item m-0">
        <a href="{{ $edit_url }}" class="btn btn-primary act-btn" data-toggle="tooltip" title="Edit">
            <span class="fas fa-edit"></span>
        </a>
    </li>
    <li class="list-inline-item m-0">
        @if ($model->id == 1)
        <button type="submit" onclick="return false" class="btn btn-danger act-btn
        btn-icon delete-btn disabled" disabled data-id="{{ $model->id }}" value="delete" data-toggle="tooltip"
            title="Hapus"><span class="fas fa-trash"></span></button>
        @else
        <form action="{{ $delete_url }}" method="post" class="d-inline">
            @method('delete')
            @csrf
            <button type="submit" class="btn btn-danger act-btn
                    btn-icon delete-btn" data-id="{{ $model->id }}" value="delete" data-toggle="tooltip"
                title="Hapus"><span class="fas fa-trash"></span></button>
        </form>
        @endif
    </li>
</ul>