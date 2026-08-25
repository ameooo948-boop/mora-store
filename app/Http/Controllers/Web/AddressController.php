<?php

namespace App\Http\Controllers\Web;

use App\DTOs\Address\CreateAddressData;
use App\DTOs\Address\UpdateAddressData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\StoreAddressRequest;
use App\Http\Requests\Web\UpdateAddressRequest;
use App\Models\Address;
use App\Services\AddressService;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function __construct(
        private readonly AddressService $addressService,
    ) {}

    public function index(Request $request)
    {
        $addresses = $this->addressService
            ->paginate($request->user());

        return view(
            'web.addresses.index',
            compact('addresses')
        );
    }

    public function create(Request $request)
    {
        if ($request->user()->addresses()->count() >= 4) {
            return redirect()->back()
                ->with('error', 'You can only have a maximum of 4 addresses.');
        }

        return view('web.addresses.create');
    }

    public function store(StoreAddressRequest $request)
    {
        $data = $request->validated();

        $data['user_id'] = $request->user()->id;

        $this->addressService->create(
            new CreateAddressData(
                user: $request->user(),
                fullName: $request->string('full_name')->value(),
                phone: $request->string('phone')->value(),
                country: $request->string('country')->value(),
                state: $request->string('state')->value(),
                city: $request->string('city')->value(),
                addressLine: $request->string('address_line')->value(),
                postalCode: $request->input('postal_code'),
                isDefault: $request->boolean('is_default'),
            )
        );

        return redirect()
            ->route('addresses.index')
            ->with(
                'success',
                'Address created successfully.'
            );
    }

    public function edit(Request $request, Address $address)
    {
        $address = $this->addressService
            ->find(
                $request->user(),
                $address->id
            );

        abort_if(! $address, 404);

        return view(
            'web.addresses.edit',
            compact('address')
        );
    }

    public function update(
        UpdateAddressRequest $request,
        Address $address
    ) {
        $address = $this->addressService
            ->find(
                $request->user(),
                $address->id
            );

        abort_if(! $address, 404);

        $this->addressService->update(
            $address,
            new UpdateAddressData(
                fullName: $request->string('full_name')->value(),
                phone: $request->string('phone')->value(),
                country: $request->string('country')->value(),
                state: $request->string('state')->value(),
                city: $request->string('city')->value(),
                addressLine: $request->string('address_line')->value(),
                postalCode: $request->input('postal_code'),
                isDefault: $request->boolean('is_default'),
            )
        );

        return redirect()
            ->route('addresses.index')
            ->with(
                'success',
                'Address updated successfully.'
            );
    }

    public function destroy(
        Request $request,
        Address $address
    ) {
        $address = $this->addressService
            ->find(
                $request->user(),
                $address->id
            );

        abort_if(! $address, 404);

        $this->addressService
            ->delete($address);

        return back()
            ->with(
                'success',
                'Address deleted successfully.'
            );
    }

    public function setDefault(
        Request $request,
        Address $address
    ) {
        $address = $this->addressService
            ->find(
                $request->user(),
                $address->id
            );

        abort_if(! $address, 404);

        $this->addressService
            ->setDefault($address);

        return back()
            ->with(
                'success',
                'Default address updated.'
            );
    }
}
