{!! Form::model($model, ['url' => $delete_url, 'method' => 'delete', 'class' => 'form-inline']) !!}
    <a href="{{ $detail_url }}" class="btn btn-success btn-circle" data-toggle="tooltip" title="Detail"> <span class="fa fa-search"></span></a> |
	<a href="{{ $edit_url }}" class="btn btn-primary btn-circle" data-toggle="tooltip" title="Edit"> <span class="fas fa-pencil-alt"></span></a> |
	<button type="submit" class="btn btn-danger btn-circle js-submit-confirm" value="delete"  data-toggle="tooltip" title="Hapus" ><span class="fa fa-trash"></span></button>
{!! Form::close()!!}