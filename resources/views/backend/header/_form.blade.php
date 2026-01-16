<div class="col-12">
    <div class="card" id="header-card">
        <div class="card-header sticky-top bg-white">
            <h4>Header Form</h4>
            <div class="card-header-action">
                <button class="btn btn-icon btn-primary"
                    onclick="$(this).addClass('btn-progress'); $.simpleCardProgress('#header-card')"><i
                        class="fas fa-save"></i> Update
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label class="form-control-label" for="title">Title</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                            name="title" autofocus value="{{ old('title', $header->title) }}">
                        @error('title')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label class="form-control-label" for="sub_title">Sub Title</label>
                        <input type="text" class="form-control @error('sub_title') is-invalid @enderror" id="sub_title"
                            name="sub_title" autofocus value="{{ old('sub_title', $header->sub_title) }}">
                        @error('sub_title')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label class="form-control-label" for="video_url">Video Url</label>
                        <input type="text" class="form-control @error('video_url') is-invalid @enderror" id="video_url"
                            name="video_url" value="{{ old('video_url', $header->video_url) }}">
                        @error('video_url')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-12 col-md-8">
                    <div class="form-group">
                        <label class="form-control-label"> Caption</label>
                        <textarea class=" form-control tinyMce @error('caption') is-invalid @enderror" id="caption"
                            name="caption">{!! old('caption', $header->caption) !!}</textarea>
                        @error('caption')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-12 col-md-4 text-center">
                    <div class="form-group">
                        <label class="form-control-label">Image</label>
                        <x-jasni-bootstrap name="image" :model="$header->image_url" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@section('script')
<script type="module">
    $(function () {
        $.myTinyMceLite('#caption', 200);
    });
</script>

@endsection