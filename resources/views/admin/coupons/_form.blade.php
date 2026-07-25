<div class="row">

    <div class="col-md-6 mb-3">

        <label class="form-label">
            Code
        </label>

        <input type="text" name="code" class="form-control @error('code') is-invalid @enderror" value="{{ old('code', $coupon->code ?? '') }}">

        @error('code')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror

    </div>

    <div class="col-md-6 mb-3">

        <label class="form-label">
            Type
        </label>

        <select name="type" class="form-select @error('type') is-invalid @enderror">

            @foreach(\App\Enums\CouponType::cases() as $type)

            <option value="{{ $type->value }}" @selected(old('type', $coupon->type->value ?? '') == $type->value)>

                {{ ucfirst($type->value) }}

            </option>

            @endforeach

        </select>

        @error('type')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror

    </div>

    <div class="col-md-6 mb-3">

        <label class="form-label">
            Value
        </label>

        <input type="number" step="0.01" min="0" name="value" class="form-control @error('value') is-invalid @enderror" value="{{ old('value', $coupon->value ?? '') }}">

        @error('value')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror

    </div>

    <div class="col-md-6 mb-3">

        <label class="form-label">
            Usage Limit
        </label>

        <input type="number" min="1" name="usage_limit" class="form-control @error('usage_limit') is-invalid @enderror" value="{{ old('usage_limit', $coupon->usage_limit ?? '') }}">

        @error('usage_limit')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror

    </div>

    <div class="col-md-6 mb-3">

        <label class="form-label">
            Minimum Order Amount
        </label>

        <input type="number" step="0.01" min="0" name="minimum_amount" class="form-control @error('minimum_amount') is-invalid @enderror" value="{{ old('minimum_amount', $coupon->minimum_amount ?? '') }}">

        @error('minimum_amount')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror

    </div>

    <div class="col-md-6 mb-3">

        <label class="form-label">
            Maximum Discount
        </label>

        <input type="number" step="0.01" min="0" name="maximum_discount" class="form-control @error('maximum_discount') is-invalid @enderror" value="{{ old('maximum_discount', $coupon->maximum_discount ?? '') }}">

        @error('maximum_discount')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror

    </div>

    <div class="col-md-6 mb-3">

        <label class="form-label">
            Starts At
        </label>

        <input type="datetime-local" name="starts_at" class="form-control @error('starts_at') is-invalid @enderror" value="{{ old(
                'starts_at',
                isset($coupon) && $coupon->starts_at
                    ? $coupon->starts_at->format('Y-m-d\TH:i')
                    : ''
            ) }}">

        @error('starts_at')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror

    </div>

    <div class="col-md-6 mb-3">

        <label class="form-label">
            Expires At
        </label>

        <input type="datetime-local" name="expires_at" class="form-control @error('expires_at') is-invalid @enderror" value="{{ old(
                'expires_at',
                isset($coupon) && $coupon->expires_at
                    ? $coupon->expires_at->format('Y-m-d\TH:i')
                    : ''
            ) }}">

        @error('expires_at')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror

    </div>

    <div class="col-md-12 mb-4">

        <div class="form-check">

            <input type="hidden" name="is_active" value="0">

            <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" @checked(old('status', $coupon->status ?? true))
            >

            <label class="form-check-label" for="is_active">

                Active

            </label>

        </div>

    </div>

</div>

<div class="text-end">

    <button type="submit" class="btn btn-primary">

        <i class="fas fa-save me-1"></i>

        Save

    </button>

    <a href="{{ route('admin.coupons.index') }}" class="btn btn-secondary">

        Cancel

    </a>

</div>

@if(isset($coupon))

<div class="card mt-4">

    <div class="card-header">

        Coupon Statistics

    </div>

    <div class="card-body">

        <div class="row">

            <div class="col-md-4">

                <strong>Used:</strong>

                {{ $coupon->used_count }}

            </div>

            <div class="col-md-4">

                <strong>Limit:</strong>

                {{ $coupon->usage_limit ?? 'Unlimited' }}

            </div>

            <div class="col-md-4">

                <strong>Remaining:</strong>

                {{ $coupon->usage_limit ? max(0, $coupon->usage_limit - $coupon->used_count) : '∞' }}

            </div>

        </div>

    </div>

</div>

@endif
