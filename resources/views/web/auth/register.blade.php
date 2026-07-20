<div class="col-md-5 mx-auto">
    <div class="card card-success shadow">

        <div class="card-header text-center">
            <h3 class="card-title m-0">
                <i class="fas fa-user-plus mr-2"></i>
                Create Account
            </h3>
        </div>

        <form action="{{ route('register') }}" method="POST">
            @csrf

            <div class="card-body">

                <!-- Name -->
                <div class="form-group">
                    <label for="name">
                        <i class="fas fa-user mr-1"></i>
                        Full Name
                    </label>

                    <input
                        type="text"
                        name="name"
                        id="name"
                        class="form-control"
                        placeholder="Enter your full name"
                        value="{{ old('name') }}"
                        required>

                    @error('name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Email -->
                <div class="form-group">
                    <label for="email">
                        <i class="fas fa-envelope mr-1"></i>
                        Email Address
                    </label>

                    <input
                        type="email"
                        name="email"
                        id="email"
                        class="form-control"
                        placeholder="Enter your email"
                        value="{{ old('email') }}"
                        required>

                    @error('email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="password">
                        <i class="fas fa-lock mr-1"></i>
                        Password
                    </label>

                    <input
                        type="password"
                        name="password"
                        id="password"
                        class="form-control"
                        placeholder="Enter your password"
                        required>

                    @error('password')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="form-group">
                    <label for="password_confirmation">
                        <i class="fas fa-lock mr-1"></i>
                        Confirm Password
                    </label>

                    <input
                        type="password"
                        name="password_confirmation"
                        id="password_confirmation"
                        class="form-control"
                        placeholder="Confirm your password"
                        required>
                </div>

            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-success btn-block">
                    <i class="fas fa-user-plus mr-1"></i>
                    Create Account
                </button>
            </div>
        </form>

    </div>
</div>