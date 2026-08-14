<div class="address-form-card">

    {{-- =====================================================
        HEADER
    ====================================================== --}}

    <div class="address-form-header">

        <div class="address-form-heading">

            <div class="address-form-icon">
                <i class="bi bi-geo-alt-fill"></i>
            </div>

            <div>

                <span>
                    DELIVERY DETAILS
                </span>

                <h2>
                    Address Information
                </h2>

                <p>
                    Add your delivery details so we know where to send your order.
                </p>

            </div>

        </div>

    </div>


    {{-- =====================================================
        FORM
    ====================================================== --}}

    <div class="address-form-body">

        <div class="row g-4">


            {{-- Full Name --}}

            <div class="col-md-6">

                <div class="address-field">

                    <label for="full_name">
                        Full Name
                        <span>*</span>
                    </label>

                    <div class="address-input-wrap">

                        <i class="bi bi-person"></i>

                        <input id="full_name" type="text" name="full_name" value="{{ old('full_name', $address->full_name ?? '') }}" placeholder="Enter your full name" autocomplete="name" class="@error('full_name') is-invalid @enderror">

                    </div>

                    @error('full_name')

                    <small class="address-field-error">
                        <i class="bi bi-exclamation-circle"></i>
                        {{ $message }}
                    </small>

                    @enderror

                </div>

            </div>


            {{-- Phone --}}

            <div class="col-md-6">

                <div class="address-field">

                    <label for="phone">
                        Phone Number
                        <span>*</span>
                    </label>

                    <div class="address-input-wrap">

                        <i class="bi bi-telephone"></i>

                        <input id="phone" type="tel" name="phone" value="{{ old('phone', $address->phone ?? '') }}" placeholder="Enter your phone number" autocomplete="tel" class="@error('phone') is-invalid @enderror">

                    </div>

                    @error('phone')

                    <small class="address-field-error">
                        <i class="bi bi-exclamation-circle"></i>
                        {{ $message }}
                    </small>

                    @enderror

                </div>

            </div>


            {{-- Country --}}

            <div class="col-md-4">

                <div class="address-field">

                    <label for="country">
                        Country
                    </label>

                    <div class="address-input-wrap">

                        <i class="bi bi-globe2"></i>

                        <input id="country" type="text" name="country" value="{{ old('country', $address->country ?? '') }}" placeholder="Country" autocomplete="country-name">

                    </div>

                </div>

            </div>


            {{-- State --}}

            <div class="col-md-4">

                <div class="address-field">

                    <label for="state">
                        State / Province
                    </label>

                    <div class="address-input-wrap">

                        <i class="bi bi-map"></i>

                        <input id="state" type="text" name="state" value="{{ old('state', $address->state ?? '') }}" placeholder="State or province" autocomplete="address-level1">

                    </div>

                </div>

            </div>


            {{-- City --}}

            <div class="col-md-4">

                <div class="address-field">

                    <label for="city">
                        City
                    </label>

                    <div class="address-input-wrap">

                        <i class="bi bi-buildings"></i>

                        <input id="city" type="text" name="city" value="{{ old('city', $address->city ?? '') }}" placeholder="City" autocomplete="address-level2">

                    </div>

                </div>

            </div>


            {{-- Address --}}

            <div class="col-12">

                <div class="address-field">

                    <label for="address_line">
                        Street Address
                        <span>*</span>
                    </label>

                    <div class="address-textarea-wrap">

                        <i class="bi bi-house"></i>

                        <textarea id="address_line" name="address_line" rows="4" placeholder="Street name, building number, apartment..." autocomplete="street-address">{{ old('address_line', $address->address_line ?? '') }}</textarea>

                    </div>

                </div>

            </div>


            {{-- Postal Code --}}

            <div class="col-md-6">

                <div class="address-field">

                    <label for="postal_code">
                        Postal Code
                    </label>

                    <div class="address-input-wrap">

                        <i class="bi bi-mailbox"></i>

                        <input id="postal_code" type="text" name="postal_code" value="{{ old('postal_code', $address->postal_code ?? '') }}" placeholder="Postal / ZIP code" autocomplete="postal-code">

                    </div>

                </div>

            </div>


            {{-- Default Address --}}

            <div class="col-md-6">

                <label class="default-address-option">

                    <input type="checkbox" name="is_default" value="1" {{ old('is_default', $address->is_default ?? false) ? 'checked' : '' }}>

                    <span class="default-address-check">

                        <i class="bi bi-check"></i>

                    </span>

                    <span class="default-address-content">

                        <strong>
                            Make this my default address
                        </strong>

                        <small>
                            Use this address automatically during checkout.
                        </small>

                    </span>

                </label>

            </div>

        </div>

    </div>


    {{-- =====================================================
        FOOTER
    ====================================================== --}}

    <div class="address-form-footer">

        <div class="address-required-note">

            <i class="bi bi-info-circle"></i>

            <span>
                Fields marked with <strong>*</strong> are required.
            </span>

        </div>


        <div class="address-form-actions">

            <a href="{{ route('addresses.index') }}" class="address-cancel-btn">

                <i class="bi bi-x-lg"></i>

                Cancel

            </a>


            <button type="submit" class="address-save-btn">

                <i class="bi bi-check2"></i>

                <span>
                    Save Address
                </span>

            </button>

        </div>

    </div>

</div>
