<div class="col-md-5 mx-auto">
    <div class="card card-primary shadow">
        <div class="card-header text-center">
            <h3 class="card-title m-0">
                <i class="fas fa-sign-in-alt mr-2"></i>
                Login
            </h3>
        </div>

        <form action="{{ route('login') }}" method="POST" class="card-body">
            @csrf

            <div class="card-body">

                <!-- Email -->
                <div class="form-group">
                    <label for="email">
                        <i class="fas fa-envelope mr-1"></i>
                        Email
                    </label>

                    <input
                        type="email"
                        class="form-control"
                        id="email"
                        name="email"
                        placeholder="Enter your email"
                        required
                        autofocus>

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
                        class="form-control"
                        id="password"
                        name="password"
                        placeholder="Enter your password"
                        required>

                    @error('password')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="form-check mb-3">
                    <input
                        type="checkbox"
                        class="form-check-input"
                        id="remember"
                        name="remember">

                    <label class="form-check-label" for="remember">
                        Remember Me
                    </label>
                </div>

            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary btn-block">
                    <i class="fas fa-sign-in-alt mr-1"></i>
                    Login
                </button>
            </div>
        </form>
    </div>
</div>