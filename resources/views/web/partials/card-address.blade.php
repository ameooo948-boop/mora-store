<div class="card border-0 shadow-sm h-100">

    @if($address->is_default)

    <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">

        <span>

            <i class="bi bi-house-check-fill me-2"></i>

            Default Address

        </span>

        <i class="bi bi-check-circle-fill"></i>

    </div>

    @endif

    <div class="card-body">

        <div class="mb-3">

            <h5 class="fw-bold mb-1">

                {{ $address->full_name }}

            </h5>

            <small class="text-muted">

                <i class="bi bi-telephone me-1"></i>

                {{ $address->phone }}

            </small>

        </div>

        <div class="mb-3">

            <i class="bi bi-geo-alt text-primary me-2"></i>

            {{ $address->country }},
            {{ $address->state }},
            {{ $address->city }}

        </div>

        <div class="mb-3">

            <i class="bi bi-house-door text-primary me-2"></i>

            {{ $address->address_line }}

        </div>

        @if($address->postal_code)

        <div>

            <i class="bi bi-mailbox text-primary me-2"></i>

            {{ $address->postal_code }}

        </div>

        @endif

    </div>

    <div class="card-footer bg-white">

        <div class="dropdown">

            <button class="btn btn-light w-100" data-bs-toggle="dropdown">

                <i class="bi bi-three-dots"></i>

                Actions

            </button>

            <ul class="dropdown-menu dropdown-menu-end">

                <li>

                    <a href="{{ route('addresses.edit', $address) }}" class="dropdown-item">

                        <i class="bi bi-pencil-square me-2"></i>

                        Edit

                    </a>

                </li>

                @unless($address->is_default)

                <li>

                    <form action="{{ route('addresses.default', $address) }}" method="POST">

                        @csrf
                        @method('PATCH')

                        <button class="dropdown-item">

                            <i class="bi bi-check2-circle me-2"></i>

                            Make Default

                        </button>

                    </form>

                </li>

                @endunless

                <li>

                    <hr class="dropdown-divider">

                </li>

                <li>

                    <form action="{{ route('addresses.destroy', $address) }}" method="POST" onsubmit="return confirm('Delete this address?')">

                        @csrf
                        @method('DELETE')

                        <button class="dropdown-item text-danger">

                            <i class="bi bi-trash me-2"></i>

                            Delete

                        </button>

                    </form>

                </li>

            </ul>

        </div>

    </div>

</div>
