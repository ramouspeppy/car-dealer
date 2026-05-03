<div class="col-12">
    <div class="card card-primary" id="card-service">
        <div class="card-header sticky-top bg-white">
            <h4>Service Form</h4>
            <div class="card-header-action">
                <button type="submit" onclick="$(this).addClass('btn-progress'); $.simpleCardProgress('#card-service')" class="btn btn-icon btn-primary"><i class="fas fa-save"></i>
                    {{ $service->id ? 'Update Service' : 'Create Service' }}
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" autofocus value="{{ old('title', $service->title) }}">
                        @error('title')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="icon">Icon</label>
                        <input type="text" class="form-control @error('icon') is-invalid @enderror" id="icon" name="icon" autofocus value="{{ old('icon', $service->icon) }}">
                        @error('icon')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="priority">Priority</label>
                        <input type="text" class="form-control @error('priority') is-invalid @enderror" id="priority" name="priority" autofocus value="{{ old('priority', $service->priority) }}">
                        @error('priority')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="form-control-label">Description</label>
                        <textarea class="form-control @error('desc') is-invalid @enderror" id="desc" name="desc" rows="2">{!! old('desc', $service->desc) !!}</textarea>
                        @error('desc')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@section('script')
    <script type="module">
        $(function() {
            $.myTinyMce('#desc', 300);
        });
    </script>
@endsection
