<div class="coupon-form-card">

    {{-- =====================================================
         COUPON DETAILS
    ====================================================== --}}

    <div class="coupon-form-section">

        <div class="coupon-section-header">

            <div class="coupon-section-icon blue">
                <i class="bi bi-ticket-perforated-fill"></i>
            </div>

            <div>
                <h3>Coupon Details</h3>
                <span>Configure the coupon code and discount type</span>
            </div>

        </div>


        <div class="coupon-form-grid">

            {{-- Code --}}
            <div class="coupon-field">

                <label>
                    Coupon Code
                    <span>*</span>
                </label>

                <div class="coupon-input">

                    <i class="bi bi-upc-scan"></i>

                    <input type="text" name="code" value="{{ old('code', $coupon->code ?? '') }}" placeholder="e.g. SUMMER25" class="@error('code') is-invalid @enderror">

                </div>

                @error('code')
                <div class="coupon-error">{{ $message }}</div>
                @enderror

            </div>


            {{-- Type --}}
            <div class="coupon-field">

                <label>
                    Discount Type
                    <span>*</span>
                </label>

                <div class="coupon-input">

                    <i class="bi bi-percent"></i>

                    <select name="type" class="@error('type') is-invalid @enderror">

                        @foreach(\App\Enums\CouponType::cases() as $type)

                        <option value="{{ $type->value }}" @selected( old( 'type' , $coupon->type->value ?? ''
                            ) == $type->value
                            )
                            >
                            {{ ucfirst($type->value) }}
                        </option>

                        @endforeach

                    </select>

                </div>

                @error('type')
                <div class="coupon-error">{{ $message }}</div>
                @enderror

            </div>


            {{-- Value --}}
            <div class="coupon-field">

                <label>
                    Discount Value
                    <span>*</span>
                </label>

                <div class="coupon-input">

                    <i class="bi bi-cash-stack"></i>

                    <input type="number" step="0.01" min="0" name="value" value="{{ old('value', $coupon->value ?? '') }}" placeholder="0.00" class="@error('value') is-invalid @enderror">

                </div>

                @error('value')
                <div class="coupon-error">{{ $message }}</div>
                @enderror

            </div>


            {{-- Usage Limit --}}
            <div class="coupon-field">

                <label>
                    Usage Limit
                </label>

                <div class="coupon-input">

                    <i class="bi bi-people"></i>

                    <input type="number" min="1" name="usage_limit" value="{{ old('usage_limit', $coupon->usage_limit ?? '') }}" placeholder="Unlimited" class="@error('usage_limit') is-invalid @enderror">

                </div>

                @error('usage_limit')
                <div class="coupon-error">{{ $message }}</div>
                @enderror

            </div>

        </div>

    </div>


    {{-- =====================================================
         ORDER CONDITIONS
    ====================================================== --}}

    <div class="coupon-form-section">

        <div class="coupon-section-header">

            <div class="coupon-section-icon green">
                <i class="bi bi-cart-check-fill"></i>
            </div>

            <div>
                <h3>Order Conditions</h3>
                <span>Define the minimum order and maximum discount</span>
            </div>

        </div>


        <div class="coupon-form-grid">

            {{-- Minimum Amount --}}
            <div class="coupon-field">

                <label>
                    Minimum Order Amount
                </label>

                <div class="coupon-input">

                    <i class="bi bi-cart"></i>

                    <input type="number" step="0.01" min="0" name="minimum_amount" value="{{ old('minimum_amount', $coupon->minimum_amount ?? '') }}" placeholder="0.00" class="@error('minimum_amount') is-invalid @enderror">

                </div>

                @error('minimum_amount')
                <div class="coupon-error">{{ $message }}</div>
                @enderror

            </div>


            {{-- Maximum Discount --}}
            <div class="coupon-field">

                <label>
                    Maximum Discount
                </label>

                <div class="coupon-input">

                    <i class="bi bi-shield-check"></i>

                    <input type="number" step="0.01" min="0" name="maximum_discount" value="{{ old('maximum_discount', $coupon->maximum_discount ?? '') }}" placeholder="No limit" class="@error('maximum_discount') is-invalid @enderror">

                </div>

                @error('maximum_discount')
                <div class="coupon-error">{{ $message }}</div>
                @enderror

            </div>

        </div>

    </div>


    {{-- =====================================================
         VALIDITY
    ====================================================== --}}

    <div class="coupon-form-section">

        <div class="coupon-section-header">

            <div class="coupon-section-icon purple">
                <i class="bi bi-calendar-event-fill"></i>
            </div>

            <div>
                <h3>Coupon Validity</h3>
                <span>Set when this coupon becomes active and expires</span>
            </div>

        </div>


        <div class="coupon-form-grid">

            {{-- Starts --}}
            <div class="coupon-field">

                <label>
                    Starts At
                </label>

                <div class="coupon-input">

                    <i class="bi bi-calendar-plus"></i>

                    <input type="datetime-local" name="starts_at" value="{{ old(
                            'starts_at',
                            isset($coupon) && $coupon->starts_at
                                ? $coupon->starts_at->format('Y-m-d\TH:i')
                                : ''
                        ) }}" class="@error('starts_at') is-invalid @enderror">

                </div>

                @error('starts_at')
                <div class="coupon-error">{{ $message }}</div>
                @enderror

            </div>


            {{-- Expires --}}
            <div class="coupon-field">

                <label>
                    Expires At
                </label>

                <div class="coupon-input">

                    <i class="bi bi-calendar-x"></i>

                    <input type="datetime-local" name="expires_at" value="{{ old(
                            'expires_at',
                            isset($coupon) && $coupon->expires_at
                                ? $coupon->expires_at->format('Y-m-d\TH:i')
                                : ''
                        ) }}" class="@error('expires_at') is-invalid @enderror">

                </div>

                @error('expires_at')
                <div class="coupon-error">{{ $message }}</div>
                @enderror

            </div>

        </div>

    </div>


    {{-- =====================================================
         STATUS
    ====================================================== --}}

    <div class="coupon-form-section">

        <div class="coupon-section-header">

            <div class="coupon-section-icon orange">
                <i class="bi bi-sliders"></i>
            </div>

            <div>
                <h3>Coupon Settings</h3>
                <span>Control coupon availability</span>
            </div>

        </div>


        <div class="coupon-setting-card">

            <div class="coupon-setting-icon">

                <i class="bi bi-toggle-on"></i>

            </div>

            <div class="coupon-setting-content">

                <strong>
                    Coupon Status
                </strong>

                <span>
                    Active coupons can be used by customers.
                </span>

            </div>


            <select name="status" class="@error('status') is-invalid @enderror">

                <option value="1" @selected( (string) old( 'status' , (int) ($coupon->status ?? true)
                    ) === '1'
                    )
                    >
                    Active
                </option>

                <option value="0" @selected( (string) old( 'status' , (int) ($coupon->status ?? true)
                    ) === '0'
                    )
                    >
                    Inactive
                </option>

            </select>

        </div>

        @error('status')
        <div class="coupon-error mt-2">
            {{ $message }}
        </div>
        @enderror

    </div>


    {{-- =====================================================
         STATISTICS
    ====================================================== --}}

    @if(isset($coupon))

    <div class="coupon-statistics">

        <div class="coupon-statistics-header">

            <div class="coupon-statistics-icon">
                <i class="bi bi-bar-chart-fill"></i>
            </div>

            <div>

                <h3>
                    Coupon Statistics
                </h3>

                <span>
                    Current usage information
                </span>

            </div>

        </div>


        <div class="coupon-stat-grid">


            <div class="coupon-stat">

                <div class="coupon-stat-icon blue">
                    <i class="bi bi-graph-up"></i>
                </div>

                <div>

                    <span>
                        Used
                    </span>

                    <strong>
                        {{ $coupon->used_count }}
                    </strong>

                </div>

            </div>


            <div class="coupon-stat">

                <div class="coupon-stat-icon purple">
                    <i class="bi bi-people"></i>
                </div>

                <div>

                    <span>
                        Limit
                    </span>

                    <strong>
                        {{ $coupon->usage_limit ?? 'Unlimited' }}
                    </strong>

                </div>

            </div>


            <div class="coupon-stat">

                <div class="coupon-stat-icon green">
                    <i class="bi bi-check2-circle"></i>
                </div>

                <div>

                    <span>
                        Remaining
                    </span>

                    <strong>
                        {{
                                $coupon->usage_limit
                                    ? max(
                                        0,
                                        $coupon->usage_limit - $coupon->used_count
                                    )
                                    : '∞'
                            }}
                    </strong>

                </div>

            </div>

        </div>

    </div>

    @endif


    {{-- =====================================================
         FOOTER
    ====================================================== --}}

    <div class="coupon-form-footer">

        <a href="{{ route('admin.coupons.index') }}" class="coupon-cancel">
            <i class="bi bi-x-lg"></i>
            Cancel
        </a>

        <button type="submit" class="coupon-submit">
            <i class="bi bi-check-lg"></i>
            {{ isset($coupon) ? 'Update Coupon' : 'Create Coupon' }}
        </button>

    </div>

</div>
