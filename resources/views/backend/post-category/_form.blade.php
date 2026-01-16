<div class="col-12">
    <div class="card card-primary" id="card-post-category">
        <div class="card-header sticky-top bg-white">
            <h4>Post Category Form</h4>
            <div class="card-header-action">
                <button type="submit"
                    onclick="$(this).addClass('btn-progress'); $.simpleCardProgress('#card-post-category')"
                    class="btn btn-icon btn-primary"><i class="fas fa-save"></i>
                    {{ ($post_category->id) ? 'Update Post Category' : 'Create Post Category' }}
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title"
                    autofocus value="{{ old('title',$post_category->title) }}">
                @error('title')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="slug">Slug</label>
                <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug"
                    value="{{ old('slug',$post_category->slug) }}">
                @error('slug')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
        </div>
    </div>
</div>
@section('script')
<script type="text/javascript">
    $('#title').change(function (e) {
        $.get("{{ route('backend.post-category.checkSlug') }}", {
                'slug': $(this).val()
            },
            function (data) {
                $('#slug').val(data.slug);
            }
        );
    });
</script>
@endsection