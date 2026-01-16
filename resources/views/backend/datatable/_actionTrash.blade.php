@can('checkUser', $model)
    <ul class="list-inline m-0">
        <li class="list-inline-item m-0">
            <form action="{{ $force_destroy_url }}" method="post">
                @csrf
                @method('delete')
                <button type="submit" class="btn btn-danger act-btn force-delete-btn" data-id="{{ $model->id }}" value="delete" data-toggle="tooltip"
                    title="Delete Permanently"><span class="fas fa-trash"></span></button>
            </form>
        </li>
        <li class="list-inline-item m-0">
            <form action="{{ $restore_url }}" method="post">
                @csrf
                <button type="submit" class="btn btn-warning act-btn restore-btn" data-id="{{ $model->id }}" data-toggle="tooltip" title="Restore"><span
                        class="fas fa-trash-restore"></span></button>
            </form>
        </li>
    </ul>
@else
    <ul class="list-inline m-0">
        <li class="list-inline-item m-0">
            <button class="btn btn-danger act-btn disabled" disabled>
                <span class="fas fa-trash"></span>
            </button>
        </li>
        <li class="list-inline-item m-0">
            <button class="btn btn-warning act-btn disabled" disabled>
                <span class="fas fa-trash-restore"></span>
            </button>
        </li>
    </ul>
@endcan
