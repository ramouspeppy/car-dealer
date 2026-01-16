<div class="col-12">
    <div class="card card-primary" id="card-promo">
        <div class="card-header sticky-top bg-white">
            <h4>Promo Form</h4>
            <div class="card-header-action">
                <button type="submit" onclick="$(this).addClass('btn-progress'); $.simpleCardProgress('#card-promo')"
                    class="btn btn-icon btn-primary"><i class="fas fa-save"></i>
                    {{ ($promo->id) ? 'Update Promo' : 'Create Promo' }}
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="promo">Promo</label>
                        <input type="text" class="form-control @error('promo') is-invalid @enderror" id="promo"
                            name="promo" autofocus value="{{ old('promo',$promo->promo) }}">
                        @error('promo')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="slug">Slug</label>
                        <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug"
                            name="slug" autofocus value="{{ old('slug',$promo->slug) }}">
                        @error('slug')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="link">Link</label>
                        <input type="text" class="form-control @error('link') is-invalid @enderror" id="link"
                            name="link" autofocus value="{{ old('link',$promo->link) }}">
                        @error('link')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="form-control-label" for="priority">Effective Date</label>
                        <div class="input-group" data-td-target-input='effective_date'
                            data-td-target-toggle='effective_date'>
                            <input type="text"
                                class="form-control daterange-cus @error('effective_date') is-invalid @enderror"
                                id='effective_date' type='text' readonly name="effective_date"
                                value="{{ old('effective_date', $promo->effective_date) }}"
                                data-td-target='#effective_date' data-tempus data-format="YYYY-MM-DD"
                                placeholder="Pilih tanggal dan jam">
                            <div class="input-group-prepend">
                                <div class="input-group-text" class='input-group-text' data-td-target='#effective_date'
                                    data-td-toggle='datetimepicker'>
                                    <i class="fas fa-calendar"></i>
                                </div>
                            </div>
                            @error('effective_date')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="form-control-label" for="priority">Priority</label>
                        <input type="number" class="form-control @error('priority') is-invalid @enderror" id="priority"
                            name="priority" value="{{ old('priority', $promo->priority) }}">
                        @error('priority')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="form-control-label" for="status">Status</label>
                        <select class="form-control selectric @error('status') is-invalid @enderror" name="status">
                            <option value="active" {{ old('status', $promo->status) == 'active' ? 'selected'
                                : ''
                                }}>Active</option>
                            <option value="non active" {{ old('status', $promo->status) == 'non active' ?
                                'selected' : ''
                                }}>Non Active</option>
                        </select>
                        @error('status')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group text-center">
                        <label class="form-control-label">Main Image</label>
                        <x-jasni-bootstrap name="promo_image" :model="$promo->promo_image_url" />
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="form-group">
                        <label class="form-control-label">Description</label>
                        <textarea class="form-control @error('desc') is-invalid @enderror" id="desc" name="desc"
                            rows="2">{!! old('desc', $promo->desc) !!}</textarea>
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
    $(function () {
        $.myTinyMce('#desc', 200);
    });
</script>

<script>
    $('#promo').change(function(e) {
        $.get("{{ route('backend.promo.checkSlug') }}", {
                'slug': $(this).val()
            },
            function(data) {
                $('#slug').val(data.slug);
            }
        );
    });
</script>

@endsection