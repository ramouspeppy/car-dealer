<div class="col-12">
    <div class="card card-primary" id="user-card">
        <div class="card-header sticky-top bg-white">
            <h4>User Form</h4>
            <div class="card-header-action">
                <button type="submit" onclick="$(this).addClass('btn-progress'); $.simpleCardProgress('#user-card')"
                    class="btn btn-icon btn-primary"><i class="fas fa-save"></i>
                    {{ $user->id ? 'Update User' : 'Create User' }}
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-md-8">
                    <div class="form-group">
                        <label class="form-control-label" for="name">Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                            name="name" value="{{ old('name', $user->name) }}">
                        @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-control-label" for="slug">Slug</label>
                        <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug"
                            name="slug" value="{{ old('slug', $user->slug) }}">
                        @error('slug')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-control-label" for="username">Username</label>
                        <input type="text" class="form-control @error('username') is-invalid @enderror" id="username"
                            name="username" value="{{ old('username', $user->username) }}">
                        @error('username')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="col-12 col-md-4">
                    <div class="form-group text-center">
                        <label class="form-control-label">Image</label>
                        $user->image_url
                        <x-jasni-bootstrap name="image" :model="$user->image_url" />
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label class="form-control-label" for="email">Email</label>
                        <input type="text" class="form-control @error('email') is-invalid @enderror" id="email"
                            name="email" value="{{ old('email', $user->email) }}">
                        @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label class="form-control-label" for="role_id">Role</label>
                        <select class="form-control select2 @error('role_id') is-invalid @enderror" name="role_id">
                            <option value="">Please Choose Role</option>
                            @foreach ($roles as $role)
                            <option value="{{ $role->id }}" {{ in_array($role->id,[old('role_id',
                                $user->role_id)]) ? 'selected':''}}>
                                {{ $role->role }}
                            </option>
                            @endforeach
                        </select>
                        @error('role_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label class="form-control-label" for="password">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                            id="password" name="password">
                        @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label class="form-control-label" for="password_confirmation">Password Confirmation</label>
                        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                            id="password_confirmation" name="password_confirmation">
                        @error('password_confirmation')
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
    $('#name').change(function(e) {
        $.get("{{ route('backend.user.checkSlug') }}", {
                'slug': $(this).val()
            },
            function(data) {
                $('#slug').val(data.slug);
            }
        );
    });
</script>
@endsection