<div class="col-12">
    <div class="card card-primary" id="product-card">
        <div class="card-header sticky-top bg-white">
            <h4>Product Form</h4>
            <div class="card-header-action">
                <button type="submit" onclick="$(this).addClass('btn-progress'); $.simpleCardProgress('#product-card')"
                    class="btn btn-icon btn-primary"><i class="fas fa-save"></i>
                    {{ $product->id ? 'Update Product' : 'Create Product' }}
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-8">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="name">Name of Product</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            id="name" name="name" value="{{ old('product', $product->name) }}">
                                        @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="hero_name">Hero Name</label>
                                        <input type="text" class="form-control @error('hero_name') is-invalid @enderror"
                                            id="hero_name" name="hero_name" value="{{ old('product', $product->hero_name) }}">
                                        @error('hero_name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="slug">Slug</label>
                                        <input type="text" class="form-control @error('slug') is-invalid @enderror"
                                            id="slug" name="slug" value="{{ old('slug', $product->slug) }}">
                                        @error('slug')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-control-label">Tagline</label>
                                        <textarea class="form-control @error('tagline') is-invalid @enderror"
                                            id="tagline" name="tagline"
                                            rows="2">{!! old('tagline', $product->tagline) !!}</textarea>
                                        @error('tagline')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="disc">Discount</label>
                                        <input type="text"
                                            class="form-control mask-price @error('disc') is-invalid @enderror"
                                            id="disc" name="disc" value="{{ old('disc', $product->disc) }}">
                                        @error('disc')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="priority">Priority</label>
                                        <input type="number"
                                            class="form-control @error('priority') is-invalid @enderror" id="priority"
                                            name="priority" value="{{ old('priority', $product->priority) }}">
                                        @error('priority')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="status">Status</label>
                                        <select class="form-control selectric @error('status') is-invalid @enderror"
                                            name="status">
                                            <option value="active" {{ old('status', $product->status) == 'active' ? 'selected' : ''}}>Active</option>
                                            <option value="non active" {{ old('status', $product->status) == 'non active'? 'selected' : ''}}>Non Active</option>
                                        </select>
                                        @error('status')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="source">Source</label>
                                        <input type="text" class="form-control @error('source') is-invalid @enderror"
                                            id="source" name="source" value="{{ old('source', $product->source) }}">
                                        @error('source')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="video_url">Video URL</label>
                                        <input type="text" class="form-control @error('video_url') is-invalid @enderror"
                                            id="video_url" name="video_url"
                                            value="{{ old('video_url', $product->video_url) }}">
                                        @error('video_url')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="brochure">File Brosur</label>
                                        <div class="custom-file">
                                            <input type="file" name="brochure"
                                                class="custom-file-input  @error('brochure') is-invalid @enderror"
                                                id="brochure">
                                            <label class="custom-file-label" for="brochure">{{
                                                $product->getFirstMedia('brochure')->file_name ?? "Choose
                                                file"}}</label>
                                        </div>
                                        @error('brochure')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="product_category_id">Product
                                            Category</label>
                                        <select
                                            class="form-control select2 @error('product_category_id') is-invalid @enderror"
                                            name="product_category_id" data-placeholder="Choose Product Category">
                                            <option value=""></option>
                                            @foreach ($product_categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id', $category->id) == $product->product_category_id ? 'selected' : ''}}>
                                                {{$category->category}}
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('product_category_id')
                                        <div class="text-danger">
                                            <small>{{ $message }}</small>
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group text-center">
                                        <label class="form-control-label">Image Header</label>
                                        <x-jasni-bootstrap name="header_image" :model="$product->header_image_url" />

                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group text-center">
                                        <label class="form-control-label">Main Image</label>
                                        <x-jasni-bootstrap name="image" :model="$product->image_url" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 text-center">
                    <div class="form-group">
                        <label class="form-control-label"> Product Colors</label>
                        <x-dropzone name="product_colors" :existing-files="$product->product_colors" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label class="form-control-label"> Description</label>
                        <textarea class="form-control @error('desc') is-invalid @enderror" id="desc"
                            name="desc">{!! old('desc', $product->desc) !!}</textarea>
                        @error('desc')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label class="form-control-label">Detail Product</label>
                        <textarea class="form-control tinyMce @error('detail') is-invalid @enderror" id="detail"
                            name="detail">{!! old('detail', $product->detail) !!}</textarea>
                        @error('detail')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 text-center">
                    <div class="form-group">
                        <label class="form-control-label"> Product Galleries</label>
                        <x-dropzone name="product_gallery" :existing-files="$product->product_gallery" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@section('script')

<script>
    $('#product').change(function(e) {
        $.get("{{ route('backend.product.checkSlug') }}", {
                'slug': $(this).val()
            },
            function(data) {
                $('#slug').val(data.slug);
            }
        );
    });

</script>
<script type="module">
    $(function () {
        $.myTinyMce('#detail');
        $.myTinyMce('#desc',250);
        $.myTinyMce('#tagline',250);
    });
</script>

@endsection