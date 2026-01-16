<div class="col-12">
    <div class="card card-primary" id="testimony-card">
        <div class="card-header sticky-top bg-white">
            <h4>Testimony Form</h4>
            <div class="card-header-action">
                <button type="submit"
                    onclick="$(this).addClass('btn-progress'); $.simpleCardProgress('#testimony-card')"
                    class="btn btn-icon btn-primary"><i class="fas fa-save"></i>
                    {{ ($testimony->id) ? 'Update Testimony' : 'Create Testimony' }}
                </button>

            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="form-group text-center">
                        <label class="form-control-label" for="rating">Rating</label>
                        <input type="hidden" class="form-control @error('rating') is-invalid @enderror" id="rating"
                            name="rating" value="{{ old('rating',$testimony->rating) }}">
                        @error('rating')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group text-center">
                        <label class="form-control-label">Image</label>
                        <x-jasni-bootstrap name="image" :model="$testimony->image_url" />
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label class="form-control-label">Message</label>
                        <textarea class="form-control textarea-md @error('message') is-invalid @enderror" height="70"
                            id="message" name="message">{{ old('message', $testimony->message) }}</textarea>
                        @error('message')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label class="form-control-label" for="name">Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                            name="name" value="{{ old('name',$testimony->name) }}">
                        @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label class="form-control-label" for="job">Job</label>
                        <input type="text" class="form-control @error('job') is-invalid @enderror" id="job" name="job"
                            value="{{ old('job',$testimony->job) }}">
                        @error('job')
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
<script>
    $("#rating").rating({
        theme: 'krajee-fas',
        containerClass: 'is-star',
        hoverChangeCaption: false,
        size: "md"
    });

</script>
@endsection