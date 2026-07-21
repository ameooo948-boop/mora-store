<div class="card border-0 shadow-sm">

    <div class="card-body">

        <div class="row">

            <div class="col-md-6 mb-3">

                <label class="form-label">

                    Full Name

                </label>

                <input type="text" name="full_name" class="form-control @error('full_name') is-invalid @enderror" value="{{ old('full_name', $address->full_name ?? '') }}">

                @error('full_name')

                <div class="invalid-feedback">

                    {{ $message }}

                </div>

                @enderror

            </div>

            <div class="col-md-6 mb-3">

                <label class="form-label">

                    Phone

                </label>

                <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $address->phone ?? '') }}">

                @error('phone')

                <div class="invalid-feedback">

                    {{ $message }}

                </div>

                @enderror

            </div>

            <div class="col-md-4 mb-3">

                <label class="form-label">

                    Country

                </label>

                <input type="text" name="country" class="form-control" value="{{ old('country', $address->country ?? '') }}">

            </div>

            <div class="col-md-4 mb-3">

                <label class="form-label">

                    State

                </label>

                <input type="text" name="state" class="form-control" value="{{ old('state', $address->state ?? '') }}">

            </div>

            <div class="col-md-4 mb-3">

                <label class="form-label">

                    City

                </label>

                <input type="text" name="city" class="form-control" value="{{ old('city', $address->city ?? '') }}">

            </div>

            <div class="col-12 mb-3">

                <label class="form-label">

                    Address

                </label>

                <textarea name="address_line" rows="4" class="form-control">{{ old('address_line', $address->address_line ?? '') }}</textarea>

            </div>

            <div class="col-md-6 mb-4">

                <label class="form-label">

                    Postal Code

                </label>

                <input type="text" name="postal_code" class="form-control" value="{{ old('postal_code', $address->postal_code ?? '') }}">

            </div>

            <div class="col-md-6 d-flex align-items-center">

                <div class="form-check mt-4">

                    <input class="form-check-input" type="checkbox" name="is_default" value="1" {{ old('is_default', $address->is_default ?? false) ? 'checked' : '' }}>

                    <label class="form-check-label">

                        Set as default address

                    </label>

                </div>

            </div>

        </div>

    </div>

    <div class="card-footer bg-white">

        <div class="d-flex justify-content-end gap-2">

            <a href="{{ route('addresses.index') }}" class="btn btn-light">

                Cancel

            </a>

            <button class="btn btn-primary">

                <i class="bi bi-check-circle me-2"></i>

                Save Address

            </button>

        </div>

    </div>

</div>
