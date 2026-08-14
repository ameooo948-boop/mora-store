<div class="address-card {{ $address->is_default ? 'is-default' : '' }}">

    {{-- =====================================================
        DEFAULT BADGE
    ====================================================== --}}

    @if($address->is_default)

    <div class="address-default-badge">

        <i class="bi bi-house-check-fill"></i>

        <span>
            Default Address
        </span>

        <i class="bi bi-check-circle-fill ms-auto"></i>

    </div>

    @endif


    {{-- =====================================================
        CARD BODY
    ====================================================== --}}

    <div class="address-card-body">

        {{-- Header --}}

        <div class="address-header">

            <div class="address-person">

                <div class="address-avatar">
                    <i class="bi bi-person-fill"></i>
                </div>

                <div>

                    <h3>
                        {{ $address->full_name }}
                    </h3>

                    <a href="tel:{{ $address->phone }}" class="address-phone">
                        <i class="bi bi-telephone-fill"></i>
                        {{ $address->phone }}
                    </a>

                </div>

            </div>

        </div>


        {{-- =================================================
            LOCATION
        ================================================== --}}

        <div class="address-info">

            <div class="address-info-icon location">
                <i class="bi bi-geo-alt-fill"></i>
            </div>

            <div class="address-info-content">

                <span>
                    Location
                </span>

                <strong>
                    {{ $address->city }}, {{ $address->state }}
                </strong>

                <small>
                    {{ $address->country }}
                </small>

            </div>

        </div>


        {{-- =================================================
            ADDRESS
        ================================================== --}}

        <div class="address-info">

            <div class="address-info-icon home">
                <i class="bi bi-house-door-fill"></i>
            </div>

            <div class="address-info-content">

                <span>
                    Address
                </span>

                <strong>
                    {{ $address->address_line }}
                </strong>

                @if($address->postal_code)

                <small>
                    Postal Code: {{ $address->postal_code }}
                </small>

                @endif

            </div>

        </div>


        {{-- =================================================
            ACTIONS
        ================================================== --}}

        <div class="address-actions">

            <a href="{{ route('addresses.edit', $address) }}" class="address-edit-btn">
                <i class="bi bi-pencil-square"></i>
                Edit
            </a>


            @unless($address->is_default)

            <form action="{{ route('addresses.default', $address) }}" method="POST" class="address-action-form">
                @csrf
                @method('PATCH')

                <button type="submit" class="address-default-btn">
                    <i class="bi bi-check2-circle"></i>
                    Make Default
                </button>

            </form>

            @endunless


            <form action="{{ route('addresses.destroy', $address) }}" method="POST" class="address-action-form" onsubmit="return confirm('Delete this address?')">
                @csrf
                @method('DELETE')

                <button type="submit" class="address-delete-btn" title="Delete address" aria-label="Delete address">
                    <i class="bi bi-trash3"></i>
                </button>

            </form>

        </div>

    </div>

</div>
