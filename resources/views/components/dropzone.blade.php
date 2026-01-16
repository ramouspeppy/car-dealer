<div class="dropzone" id="dropzone-{{ $name }}"></div>

@push('scripts')
<script>
    Dropzone.autoDiscover = false;

var uploadedMap_{{ $name }} = {};

var myDropzone_{{ $name }} = new Dropzone("#dropzone-{{ $name }}", {
    url: "{{ route("backend.images.store") }}",
    maxFilesize: {{ $maxFileSize }},
    acceptedFiles: "{{ $acceptedFiles }}",
    addRemoveLinks: true,
    headers: {
        'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    success: function(file, response) {
        $('form').append('<input type="hidden" name="{{ $name }}[]" value="' + response.name + '">');
        uploadedMap_{{ $name }}[file.name] = response.name;
    },
    removedfile: function(file) {
        file.previewElement.remove();
        var name = uploadedMap_{{ $name }}[file.name] ?? file.file_name;

        $.post('{{ route("backend.images.destroy") }}', { filename: name, _token: "{{ csrf_token() }}" });

        $('form').find('input[name="{{ $name }}[]"][value="' + name + '"]').remove();
    },
    init: function() {
        @if(!empty($existingFiles))
            var files = {!! json_encode($existingFiles) !!};
            for (var i in files) {
                var file = files[i];
                this.emit("addedfile", file);
                this.emit("thumbnail", file, file.original_url);
                this.emit("complete", file);
                $('form').append('<input type="hidden" name="{{ $name }}[]" value="' + file.file_name + '">');
            }
        @endif
    }
});
</script>
@endpush