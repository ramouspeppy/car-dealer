<div class="dropzone" id="dropzone-{{ $name }}"></div>

@push('scripts')
    <script>
        Dropzone.autoDiscover = false;

        var uploadedMap_{{ $name }} = {};

        var myDropzone_{{ $name }} = new Dropzone("#dropzone-{{ $name }}", {
            url: @json($uploadUrl),
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

                $.post(@json($removeUrl), {
                    filename: name,
                    _token: "{{ csrf_token() }}"
                });

                $('form').find('input[name="{{ $name }}[]"][value="' + name + '"]').remove();
            },
            init: function() {
                var self = this;
                var tmpUrl = @json($tmpUrl);
                var existing = {!! json_encode($existingFiles ?? []) !!};
                var oldNames = @json(old($name));

                function addMock(name, url, size) {
                    var mock = {
                        name: name,
                        file_name: name,
                        size: size || 0,
                        accepted: true,
                        status: Dropzone.SUCCESS
                    };
                    self.files.push(mock);
                    self.emit('addedfile', mock);
                    self.emit('thumbnail', mock, url);
                    self.emit('complete', mock);
                    uploadedMap_{{ $name }}[name] = name;
                    $('form').append('<input type="hidden" name="{{ $name }}[]" value="' + name + '">');
                }

                if (Array.isArray(oldNames)) {
                    // validasi gagal: old() = kondisi terakhir (file database + file temp)
                    var byName = {};
                    for (var i in existing) {
                        byName[existing[i].file_name] = existing[i];
                    }

                    oldNames.forEach(function(name) {
                        var db = byName[name];
                        addMock(name, db ? db.original_url : tmpUrl + encodeURIComponent(name), db ? db.size : 0);
                    });
                } else {
                    // load normal (create kosong / edit dari database)
                    for (var i in existing) {
                        var f = existing[i];
                        addMock(f.file_name, f.original_url, f.size);
                    }
                }
            }
        });
    </script>
@endpush
