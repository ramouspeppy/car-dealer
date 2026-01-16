
<div class="float-left">
    {!! Form::model($model, ['url' => $submit_url, 'method' => 'put']) !!}
    	@if($model->status == 0 || $model->status == NULL )
            <button type="submit" class="btn btn-info btn-circle" value="submit"  data-toggle="tooltip" title="Submit" ><span class="fa fa-share"></span></button> |
        @else
            <button type="submit" onclick="return false" class="btn btn-info btn-circle disabled" value="submit"  data-toggle="tooltip" title="Submit" ><span class="fa fa-share"></span></button> |
        @endif
        <a href="{{ $detail_url }}" class="btn btn-success btn-circle" data-toggle="tooltip" title="Detail"> <span class="fa fa-search"></span></a> |
    {!! Form::close()!!}
</div>

<div class="float-right">
    {!! Form::model($model, ['url' => $delete_url, 'method' => 'delete']) !!}
        <a href="{{ $edit_url }}" class="btn btn-primary btn-circle" data-toggle="tooltip" title="Edit"> <span class="fa fa-pencil"></span></a> |
        <button type="submit" class="btn btn-danger btn-circle js-submit-confirm" value="delete"  data-toggle="tooltip" title="Hapus" ><span class="fa fa-trash"></span></button>
    {!! Form::close()!!}
</div>
