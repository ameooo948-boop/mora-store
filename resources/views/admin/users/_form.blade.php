<div class="user-form-card">

    <div class="user-form-body">

        <div class="user-form-section">

            <div class="user-form-section-title">
                <div class="user-form-section-icon">
                    <i class="bi bi-person"></i>
                </div>

                <div>
                    <strong>Account Information</strong>
                    <span>Enter the user's basic account details</span>
                </div>
            </div>

            <div class="row g-3">

                {{-- Name --}}
                <div class="col-md-6">

                    <label class="user-form-label">
                        Name
                        <span>*</span>
                    </label>

                    <input type="text" name="name" class="user-form-control @error('name') is-invalid @enderror" placeholder="Enter user name" value="{{ old('name', $user->name ?? '') }}">

                    @error('name')
                    <div class="user-form-error">
                        <i class="bi bi-exclamation-circle"></i>
                        {{ $message }}
                    </div>
                    @enderror

                </div>


                {{-- Email --}}
                <div class="col-md-6">

                    <label class="user-form-label">
                        Email Address
                        <span>*</span>
                    </label>

                    <input type="email" name="email" class="user-form-control @error('email') is-invalid @enderror" placeholder="Enter email address" value="{{ old('email', $user->email ?? '') }}">

                    @error('email')
                    <div class="user-form-error">
                        <i class="bi bi-exclamation-circle"></i>
                        {{ $message }}
                    </div>
                    @enderror

                </div>


                {{-- Password --}}
                <div class="col-md-6">

                    <label class="user-form-label">
                        Password

                        @if(!isset($user))
                        <span>*</span>
                        @endif
                    </label>

                    <input type="password" name="password" class="user-form-control @error('password') is-invalid @enderror" placeholder="{{ isset($user) ? 'Leave blank to keep current password' : 'Enter password' }}">

                    @error('password')
                    <div class="user-form-error">
                        <i class="bi bi-exclamation-circle"></i>
                        {{ $message }}
                    </div>
                    @enderror

                    @if(isset($user))
                    <small class="user-form-hint">
                        Leave blank if you don't want to change the password.
                    </small>
                    @endif

                </div>


                {{-- Confirm Password --}}
                <div class="col-md-6">

                    <label class="user-form-label">
                        Confirm Password
                    </label>

                    <input type="password" name="password_confirmation" class="user-form-control" placeholder="Confirm password">

                </div>


                {{-- Role --}}
                <div class="col-md-6">

                    <label class="user-form-label">
                        Role
                        <span>*</span>
                    </label>

                    <select name="role" class="user-form-control user-form-select @error('role') is-invalid @enderror">

                        <option value="">
                            Select Role
                        </option>

                        @foreach($roles as $role)

                        <option value="{{ $role->name }}" @selected( old( 'role' , isset($user) ? optional($user->roles->first())->name
                            : ''
                            ) == $role->name
                            )
                            >
                            {{ ucfirst($role->name) }}
                        </option>

                        @endforeach

                    </select>

                    @error('role')
                    <div class="user-form-error">
                        <i class="bi bi-exclamation-circle"></i>
                        {{ $message }}
                    </div>
                    @enderror

                </div>

            </div>

        </div>

    </div>


    {{-- Footer --}}
    <div class="user-form-footer">

        <a href="{{ route('admin.users.index') }}" class="user-form-btn user-form-btn-cancel">
            <i class="bi bi-x-lg"></i>
            Cancel
        </a>

        <button type="submit" class="user-form-btn user-form-btn-primary">
            <i class="bi bi-check-lg"></i>

            {{ isset($user) ? 'Update User' : 'Save User' }}

        </button>

    </div>

</div>


@push('styles')

<style>
    /* =========================================================
   USER FORM
========================================================= */

    .user-form-card {
        width: 100%;

        background: #fff;

        border: 1px solid #eaecf0;
        border-radius: 8px;

        overflow: hidden;
    }


    /* =========================================================
   BODY
========================================================= */

    .user-form-body {
        padding: 16px;
    }

    .user-form-section {
        width: 100%;
    }


    /* =========================================================
   SECTION HEADER
========================================================= */

    .user-form-section-title {
        display: flex;
        align-items: center;

        gap: 8px;

        margin-bottom: 15px;

        padding-bottom: 12px;

        border-bottom: 1px solid #f2f4f7;
    }

    .user-form-section-icon {
        width: 30px;
        height: 30px;

        flex: 0 0 30px;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 6px;

        background: #eef6ff;
        color: #2878d8;

        font-size: 11px;
    }

    .user-form-section-title strong {
        display: block;

        color: #344054;

        font-size: 9px;
        font-weight: 700;
    }

    .user-form-section-title span {
        display: block;

        margin-top: 2px;

        color: #98a2b3;

        font-size: 6px;
    }


    /* =========================================================
   LABEL
========================================================= */

    .user-form-label {
        display: block;

        margin-bottom: 5px;

        color: #475467;

        font-size: 7px;
        font-weight: 700;
    }

    .user-form-label span {
        color: #d92d20;

        margin-left: 2px;
    }


    /* =========================================================
   INPUT
========================================================= */

    .user-form-control {
        width: 100%;
        height: 34px;

        padding: 0 10px;

        border: 1px solid #d0d5dd;
        border-radius: 5px;

        background: #fff;

        color: #344054;

        font-size: 8px;

        outline: none;

        transition: all .15s ease;
    }

    .user-form-control::placeholder {
        color: #98a2b3;
    }

    .user-form-control:hover {
        border-color: #b8c0cc;
    }

    .user-form-control:focus {
        border-color: #84adff;

        box-shadow: 0 0 0 2px rgba(47, 128, 237, .08);
    }

    .user-form-control.is-invalid {
        border-color: #f04438;
    }

    .user-form-control.is-invalid:focus {
        box-shadow: 0 0 0 2px rgba(240, 68, 56, .08);
    }


    /* =========================================================
   SELECT
========================================================= */

    .user-form-select {
        cursor: pointer;
    }


    /* =========================================================
   ERROR
========================================================= */

    .user-form-error {
        display: flex;
        align-items: center;

        gap: 4px;

        margin-top: 4px;

        color: #d92d20;

        font-size: 6px;
        font-weight: 500;
    }

    .user-form-error i {
        font-size: 7px;
    }


    /* =========================================================
   HINT
========================================================= */

    .user-form-hint {
        display: block;

        margin-top: 4px;

        color: #98a2b3;

        font-size: 6px;
    }


    /* =========================================================
   FOOTER
========================================================= */

    .user-form-footer {
        min-height: 54px;

        padding: 10px 16px;

        display: flex;
        align-items: center;
        justify-content: flex-end;

        gap: 6px;

        background: #fafbfc;

        border-top: 1px solid #eaecf0;
    }


    /* =========================================================
   BUTTONS
========================================================= */

    .user-form-btn {
        height: 30px;

        padding: 0 11px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        gap: 5px;

        border-radius: 5px;

        font-size: 7px;
        font-weight: 700;

        text-decoration: none;

        cursor: pointer;

        transition: all .15s ease;
    }

    .user-form-btn i {
        font-size: 8px;
    }


    /* Cancel */

    .user-form-btn-cancel {
        background: #fff;

        color: #667085;

        border: 1px solid #d0d5dd;
    }

    .user-form-btn-cancel:hover {
        background: #f8fafc;

        color: #344054;

        border-color: #b8c0cc;
    }


    /* Primary */

    .user-form-btn-primary {
        border: 1px solid #2878d8;

        background: #2878d8;

        color: #fff;
    }

    .user-form-btn-primary:hover {
        background: #1f6bc4;

        border-color: #1f6bc4;

        color: #fff;
    }


    /* =========================================================
   RESPONSIVE
========================================================= */

    @media (max-width: 768px) {

        .user-form-body {
            padding: 12px;
        }

        .user-form-footer {
            padding: 9px 12px;
        }

    }

</style>

@endpush
