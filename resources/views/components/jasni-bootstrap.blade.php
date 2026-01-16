<div class="fileinput fileinput-new d-block" data-provides="fileinput">
    <div class="fileinput-new thumbnail image-upload">
        <img src="{{ $model ? $model : asset('images/no-image.png') }}">
    </div>
    <div class="fileinput-preview fileinput-exists thumbnail image-upload">
    </div>
    <div class="m-2">
        <span class="btn btn-primary btn-file">
            <span class="fileinput-new">
                Select image
            </span>
            <span class="fileinput-exists">Change</span>
            <input type="file" name="{{ $name }}" id="{{ $name }}" accept="image/*">
        </span>
        <a href="#" class="btn btn-primary fileinput-exists"
            data-dismiss="fileinput">Remove</a>
    </div>
</div>
@error($name)
<div class="text-danger">
    <small>{{ $message }}</small>
</div>
@enderror