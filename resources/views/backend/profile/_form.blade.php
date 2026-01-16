<div class="col-12">
    <form action="{{ route('backend.profile.update') }}" method="POST" enctype="multipart/form-data" id="profile-form">
        @csrf
        <div class="card card-primary" id="profile-card">
            <div class="card-header sticky-top bg-white">
                <h4>Profile</h4>
                <div class="card-header-action">
                    <button type="submit"
                        onclick="$(this).addClass('btn-progress'); $.simpleCardProgress('#profile-card')"
                        class="btn btn-icon btn-primary"><i class="fas fa-save"></i> Update</button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-8">
                        <div class="form-group">
                            <label class="form-control-label" for="name">Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name', $profile->name) }}">
                            @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-control-label" for="job_title">Job Title</label>
                            <small>(Jabatan)</small>
                            <input type="text" class="form-control @error('job_title') is-invalid @enderror"
                                id="job_title" name="job_title" 
                                value="{{ old('job_title', $profile->job_title) }}">
                            @error('job_title')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-control-label"> Bio</label>
                            <textarea class=" form-control @error('bio') is-invalid @enderror" id="bio"
                                name="bio">{!! old('bio', $profile->bio) !!}</textarea>
                            @error('bio')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-control-label">Experience</label>
                            <small>(pengalaman)</small>
                            <input type="text" class="form-control @error('experience') is-invalid @enderror"
                                id="experience" name="experience" 
                                value="{{ old('experience', $profile->experience) }}">
                            @error('experience')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-control-label">Experience</label>
                            <small>(pengalaman)</small>
                            <input type="text" class="form-control @error('experience') is-invalid @enderror"
                                id="experience" name="experience" 
                                value="{{ old('experience', $profile->experience) }}">
                            @error('experience')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-control-label">Project</label>
                            <small>(closing)</small>
                            <input type="text" class="form-control @error('project') is-invalid @enderror"
                                id="project" name="project" 
                                value="{{ old('project', $profile->project) }}">
                            @error('project')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-control-label">CLient</label>
                            <small>(tingkat kepuasan)</small>
                            <input type="text" class="form-control @error('client') is-invalid @enderror"
                                id="client" name="client" 
                                value="{{ old('client', $profile->client) }}">
                            @error('client')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12 col-md-4 text-center">
                        <div class="form-group">
                            <label class="form-control-label">Image</label>
                            <x-jasni-bootstrap name="image" :model="$profile->image_url" />
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="section-title">Contact</div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label class="form-control-label" for="address">Address</label>
                            <input type="text" class="form-control @error('address') is-invalid @enderror" id="address"
                                name="address" value="{{ old('address', $profile->address) }}">
                            @error('address')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label class="form-control-label" for="address_url">Address URL
                                <small>(Gmaps)</small>
                            </label>
                            <input type="text" class="form-control @error('address_url') is-invalid @enderror"
                                id="address_url" name="address_url" 
                                value="{{ old('address_url', $profile->address_url) }}">
                            @error('address_url')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label class="form-control-label" for="email">Email</label>
                            <input type="text" class="form-control @error('email') is-invalid @enderror" id="email"
                                name="email" value="{{ old('email', $profile->email) }}">
                            @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label class="form-control-label" for="phone">Phone Number</label>
                            <input type="text" class="form-control mask-hp @error('phone') is-invalid @enderror"
                                id="phone" name="phone" value="{{ old('phone', $profile->phone) }}">
                            @error('phone')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label class="form-control-label" for="wa">Whatsapp Number</label>
                            <input type="text" class="form-control mask-hp @error('wa') is-invalid @enderror" id="wa"
                                name="wa" value="{{ old('wa', $profile->wa) }}">
                            @error('title')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label class="form-control-label" for="wa_message">Salam via whastapp</label>
                            <select class="form-control " name="wa_message">
                                <option value="">Random</option>
                                @foreach(config('whatsapp.greetings') as $greeting)
                                    <option value="{{ $greeting }}"
                                        {{ old('greeting', $profile->wa_message) == $greeting ? 'selected' : '' }}>
                                        {{ str_replace('{name}', $profile->name, $greeting) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('wa_message')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="section-title">Media Social</div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label class="form-control-label" for="fb_url">Facebook URL</label>
                            <input type="text" class="form-control @error('fb_url') is-invalid @enderror" id="fb_url"
                                name="fb_url" value="{{ old('fb_url', $profile->fb_url) }}">
                            @error('fb_url')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label class="form-control-label" for="ig_url">Instagram URL</label>
                            <input type="text" class="form-control @error('ig_url') is-invalid @enderror" id="ig_url"
                                name="ig_url" value="{{ old('ig_url', $profile->ig_url) }}">
                            @error('ig_url')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label class="form-control-label" for="yt_url">Youtube URL</label>
                            <input type="text" class="form-control @error('yt_url') is-invalid @enderror" id="yt_url"
                                name="yt_url" value="{{ old('yt_url', $profile->yt_url) }}">
                            @error('yt_url')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label class="form-control-label" for="x_url">Twitter URL</label>
                            <input type="text" class="form-control @error('x_url') is-invalid @enderror" id="x_url"
                                name="x_url" value="{{ old('x_url', $profile->x_url) }}">
                            @error('x_url')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label class="form-control-label" for="video_url">Video</label>
                            <input type="text" class="form-control @error('video_url') is-invalid @enderror"
                                id="video_url" name="video_url" value="{{ old('video_url', $profile->video_url) }}">
                            @error('video_url')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

</div>
@section('script')
<script>
    $.myTinyMceLite('#bio',200);
</script>
@endsection