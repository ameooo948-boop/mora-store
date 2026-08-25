<?php

namespace App\Http\Controllers\Api;

use App\DTOs\Address\CreateAddressData;
use App\DTOs\Address\UpdateAddressData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\StoreAddressRequest;
use App\Http\Requests\Web\UpdateAddressRequest;
use App\Http\Resources\AddressResource;
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
        $addresses = $this->addressService->paginate($request->user());

        return response()->json([
            'addresses' => AddressResource::collection($addresses),
            'meta' => [
                'current_page' => $addresses->currentPage(),
                'last_page' => $addresses->lastPage(),
                'total' => $addresses->total(),
            ],
        ]);
    }

    public function store(StoreAddressRequest $request)
    {
        if ($request->user()->addresses()->count() >= 4) {
            return response()->json([
                'message' => 'You can only have a maximum of 4 addresses.',
            ], 422);
        }

        $address = $this->addressService->create(
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

        return response()->json([
            'message' => 'Address created successfully.',
            'address' => new AddressResource($address),
        ], 201);
    }

    public function show(Request $request, Address $address)
    {
        $address = $this->addressService->find($request->user(), $address->id);

        abort_if(! $address, 404);

        return response()->json([
            'address' => new AddressResource($address),
        ]);
    }

    public function update(
        UpdateAddressRequest $request,
        Address $address
    ) {
        $address = $this->addressService->find($request->user(), $address->id);

        abort_if(! $address, 404);

        $address = $this->addressService->update(
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

        return response()->json([
            'message' => 'Address updated successfully.',
            'address' => new AddressResource($address),
        ]);
    }

    public function destroy(
        Request $request,
        Address $address
    ) {
        $address = $this->addressService->find($request->user(), $address->id);

        abort_if(! $address, 404);

        $this->addressService->delete($address);

        return response()->json([
            'message' => 'Address deleted successfully.',
        ]);
    }

    public function setDefault(
        Request $request,
        Address $address
    ) {
        $address = $this->addressService->find($request->user(), $address->id);

        abort_if(! $address, 404);

        $this->addressService->setDefault($address);

        return response()->json([
            'message' => 'Default address updated.',
        ]);
    }
}
