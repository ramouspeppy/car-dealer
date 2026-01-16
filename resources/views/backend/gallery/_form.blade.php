<div class="col-12">
    <div class="card card-primary" id="gallery-card">
        <div class="card-header sticky-top bg-white">
            <h4>Gallery Form</h4>
            <div class="card-header-action">
                <button type="submit" onclick="$(this).addClass('btn-progress'); $.simpleCardProgress('#gallery-card')"
                    class="btn btn-icon btn-primary"><i class="fas fa-save"></i>
                    {{ $gallery->id ? 'Update Gallery' : 'Create Gallery' }}
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label class="form-control-label" for="title">Title</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                            name="title" value="{{ old('title', $gallery->title) }}">
                        @error('title')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label class="form-control-label" for="slug">Slug</label>
                        <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug"
                            name="slug" value="{{ old('slug', $gallery->slug) }}">
                        @error('slug')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-4">
                    <div class="form-group text-center">
                        <label class="form-control-label">Image Cover</label>
                        <x-jasni-bootstrap name="cover" :model="$gallery->cover_url" />
                    </div>
                </div>
                <div class="col-12 col-md-8 text-center">
                    <div class="form-group">
                        <label class="form-control-label">Gallery</label>
                        <x-dropzone name="images" :existing-files="$gallery->images" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@section('script')
{{-- <script>
    Dropzone.autoDiscover = false;
    
    var uploadedDocumentMap = {}
    
    var myDropzone = new Dropzone("div#mydropzone", {
        url: '{{ route('gallery.storeMedia') }}',
        maxFilesize: 2, // MB
        addRemoveLinks: true,
        acceptedFiles: ".jpeg,.jpg,.png,.webp", // opsional tambah webp
        headers: { 'X-CSRF-TOKEN': "{{ csrf_token() }}" },
        success: function(file, response) {
            $('form').append('<input type="hidden" name="images[]" value="' + response.name + '">')
            uploadedDocumentMap[file.name] = response.name
        },
        removedfile: function(file) {
            file.previewElement.remove()
    
            var name = ''
            if (typeof file.file_name !== 'undefined') {
                name = file.file_name
            } else {
                name = uploadedDocumentMap[file.name] || file.name
            }
    
            $.post({
                headers: { 'X-CSRF-TOKEN': "{{ csrf_token() }}" },
                url: '{{ route("gallery.deleteMedia") }}',
                data: { filename: name }
            });
    
            $('form').find('input[name="images[]"][value="' + name + '"]').remove()
        },
        init: function() {
            // --- 2a) Saat EDIT: render media yang sudah tersimpan di Spatie ---
            @if ($gallery->exists && $gallery->images)
                var files = {!! json_encode($gallery->images) !!};
                for (var i in files) {
                    var file = files[i];
                    this.emit("addedfile", file);
                    this.emit("thumbnail", file, file.original_url);
                    this.emit("complete", file);
                    // penting: masukkan ke input hidden agar tidak terhapus saat submit
                    $('form').append('<input type="hidden" name="images[]" value="' + file.file_name + '">');
                }
            @endif
    
            // --- 2b) Saat VALIDASI GAGAL (CREATE/EDIT): render ulang dari old('images') ---
            @if (is_array(old('images')))
                var oldFiles = @json(old('images'));
                var baseUrl = "{{ Storage::disk('public')->url('tmp/' . auth()->id() . '/gallery') }}";
    
                oldFiles.forEach((name) => {
                    var mockFile = { name: name };
                    this.emit("addedfile", mockFile);
                    this.emit("thumbnail", mockFile, baseUrl + '/' + name);
                    this.emit("complete", mockFile);
                    $('form').append('<input type="hidden" name="images[]" value="' + name + '">');
                    // simpan di map supaya removedfile tahu filenamenya
                    uploadedDocumentMap[name] = name;
                });
            @endif
        }
    });
</script> --}}
<script>
    $('#title').change(function(e) {
        $.get("{{ route('backend.gallery.checkSlug') }}", {
                'slug': $(this).val()
            },
            function(data) {
                $('#slug').val(data.slug);
            }
        );
    });
</script>
@endsection