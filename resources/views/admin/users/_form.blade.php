<div class="card shadow-sm border-0">

    <div class="card-body p-4">

        <div class="row">

            {{-- Name --}}
            <div class="col-md-6 mb-3">

                <label class="form-label fw-semibold">
                    Name <span class="text-danger">*</span>
                </label>

                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Enter user name" value="{{ old('name', $user->name ?? '') }}">

                @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror

            </div>

            {{-- Email --}}
            <div class="col-md-6 mb-3">

                <label class="form-label fw-semibold">
                    Email <span class="text-danger">*</span>
                </label>

                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Enter email" value="{{ old('email', $user->email ?? '') }}">

                @error('email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror

            </div>

            {{-- Password --}}
            <div class="col-md-6 mb-3">

                <label class="form-label fw-semibold">

                    Password

                </label>

                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="{{ isset($user) ? 'Leave blank to keep current password' : 'Enter password' }}">

                @error('password')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror

            </div>

            {{-- Confirm Password --}}
            <div class="col-md-6 mb-3">

                <label class="form-label fw-semibold">

                    Confirm Password

                </label>

                <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm password">

            </div>

            {{-- Role --}}
            <div class="col-md-6 mb-3">

                <label class="form-label fw-semibold">
                    Role <span class="text-danger">*</span>
                </label>

                <select name="role" class="form-select @error('role') is-invalid @enderror">

                    <option value="">
                        Select Role
                    </option>

                    @foreach($roles as $role)

                    <option value="{{ $role->name }}" @selected(old( 'role' , isset($user) ? optional($user->roles->first())->name
                        : ''
                        ) == $role->name)>

                        {{ ucfirst($role->name) }}

                    </option>

                    @endforeach

                </select>

                @error('role')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror

            </div>

        </div>

    </div>

    <div class="card-footer bg-white d-flex justify-content-end">

        <a href="{{ route('admin.users.index') }}" class="btn btn-light me-2">

            Cancel

        </a>

        <button type="submit" class="btn btn-primary">

            <i class="bi bi-check-lg"></i>

            {{ isset($user) ? 'Update User' : 'Save User' }}

        </button>

    </div>

</div>
