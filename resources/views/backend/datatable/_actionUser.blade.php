<ul class="list-inline m-0">
    <li class="list-inline-item m-0">
        @can('isAdmin', $model)
        <a href="{{ $show_url }}" class="btn btn-success btn-icon act-btn" data-toggle="tooltip" title="Edit">
            <span class="fas fa-search"></span>
        </a>
        @else
        <a href="#" class="btn btn-success btn-icon act-btn disabled" disabled data-toggle="tooltip" title="Edit">
            <span class="fas fa-search"></span>
        </a>
        @endcan
    </li>
    <li class="list-inline-item m-0">
        @can('isAdmin', $model)
        <form action="{{ $reset_url }}" method="post" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-warning act-btn btn-icon" value="reset" data-toggle="tooltip"
                title="Reset Password"><span class="fas fa-redo"></span></button>
        </form>
        @else
        <a href="#" class="btn btn-danger act-btn btn-icon disabled" disabled>
            <span class="fas fa-trash"></span>
        </a>
        @endcan

    </li>
    <li class="list-inline-item m-0">
        @can('isAdmin', $model)
        <form action="{{ $delete_url }}" method="post" class="d-inline">
            @method('delete')
            @csrf
            <button type="submit" class="btn btn-danger act-btn btn-icon delete-btn" data-id="{{ $model->id }}"
                value="delete" data-toggle="tooltip" title="Delete"><span class="fas fa-trash"></span></button>
        </form>
        @else
        <a href="#" class="btn btn-danger act-btn btn-icon disabled" disabled>
            <span class="fas fa-trash"></span>
        </a>
        @endcan

    </li>
</ul>