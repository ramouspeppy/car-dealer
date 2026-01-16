<div class="col-12">
    <div class="card" id="form-post" style="background: transparent !important; box-shadow: none ">
        <div class="row">
            <div class="col-12 col-md-8">
                <div class="card card-primary">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                                name="title" autofocus value="{{ old('title', $post->title) }}">
                            @error('title')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="slug">Slug</label>
                            <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug"
                                name="slug" value="{{ old('slug', $post->slug) }}">
                            @error('slug')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label> Excerpt</label>
                            <textarea class="form-control textarea-md @error('excerpt') is-invalid @enderror"
                                height="70" id="excerpt" name="excerpt">{{ old('excerpt', $post->excerpt) }}</textarea>
                            @error('excerpt')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label> Content</label>
                            <textarea class=" form-control @error('body') is-invalid @enderror" id="body"
                                name="body">{!! old('body', $post->body) !!}</textarea>
                            @error('body')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="card card-{{ $errors->has('published_at') ? 'danger' : 'primary' }}">
                    <div class="card-header pb-0">
                        <h4>Publish</h4>
                    </div>
                    <div class="card-body pt-0">
                        <div class="input-group" id='published_at' data-td-target-input='nearest'
                            data-td-target-toggle='nearest'>
                            <input type="text"
                                class="form-control daterange-cus @error(' published_at') is-invalid @enderror"
                                id='published_atInput' type='text' readonly name="published_at"
                                value="{{ old('published_at', $post->published_at) }}" data-td-target='#published_at'
                                data-tempus data-format="YYYY-MM-DD HH:mm:ss" placeholder="Pilih tanggal dan jam">
                            <div class="input-group-prepend">
                                <div class="input-group-text" class='input-group-text' data-td-target='#published_at'
                                    data-td-toggle='datetimepicker'>
                                    <i class="fas fa-calendar"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer clearfix bg-whitesmoke ">
                        <div class="float-left">
                            <a class="btn btn-primary" id="draft-btn">Save as Draft</a>
                        </div>
                        <div class="float-right">
                            <button class="btn btn-primary" id="save-btn">{{ $post->id ? 'Update Post' : 'Create Post'
                                }}</button>
                        </div>
                    </div>
                </div>
                <div class="card card-{{ $errors->has('post_category_id') ? 'danger' : 'warning' }}">
                    <div class="card-header pb-0">
                        <h4>Category</h4>
                    </div>
                    <div class="card-body pt-0">
                        <select class="form-control select2 @error('post_category_id') is-invalid @enderror"
                            name="post_category_id">
                            <option value="">Please Choose Your Category</option>
                            @foreach ($categories as $category)
                            @if (old('post_category_id', $post->post_category_id) == $category->id)
                            <option value="{{ $category->id }}" selected>
                                {{ $category->title }}</option>
                            @else
                            <option value="{{ $category->id }}">{{ $category->title }}
                            </option>
                            @endif
                            @endforeach
                        </select>
                        @error('post_category_id')
                        <div class="text-danger">
                            <small>{{ $message }}</small>
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="card card-{{ $errors->has('post_tags') ? 'danger' : 'warning' }}">
                    <div class="card-header pb-0">
                        <h4>Tags </h4>
                    </div>
                    <div class="card-body pt-0">
                        <select class="form-control select2 @error('post_tags') is-invalid @enderror" name="post_tags[]"
                            multiple="multiple" data-tags="true">
                            @foreach ($tags as $tag)
                            <option value="{{ $tag->name }}" {{ in_array($tag->name, $selectedTags) ? 'selected' : ''
                                }}>
                                {{ $tag->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('post_tags')
                        <div class="text-danger">
                            <small>{{ $message }}</small>
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="card card-{{ $errors->has('image') ? 'danger' : 'info' }}">
                    <div class="card-header pb-0">
                        <h4>Image</h4>
                    </div>
                    <div class="card-body pt-0 text-center">
                        $post->image_thumb_url 
                        <x-jasni-bootstrap name="image" :model="$post->image_thumb_url " />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('css')
@endsection
@section('script')
<script type="text/javascript">
    $('#title').change(function (e) {
        $.get("{{ route('backend.post.checkSlug') }}", {
                'slug': $(this).val()
            },
            function (data) {
                $('#slug').val(data.slug);
            }
        );
    });
    $('#save-btn').click(function (e) {
        e.preventDefault();
        $('#save-btn').addClass('btn-progress');

        $.cardProgress('#form-post', {
            dismiss: false
        });

        $('#post-form').submit();
    });

    $('#draft-btn').click(function (e) {
        e.preventDefault();
        $('#draft-btn').addClass('btn-progress');

        $.cardProgress('#form-post', {
            dismiss: false
        });

        $('#published_atInput').val("");

        $('#post-form').submit();
    });

</script>
<script type="module">
    $(function () {
        $.myTinyMce('#body', 200);
    });
</script>

@endsection