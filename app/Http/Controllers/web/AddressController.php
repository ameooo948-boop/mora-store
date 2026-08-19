<?php

namespace App\Http\Controllers\Web;

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

        $this->addressService->create($data);

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

        $this->addressService
            ->update(
                $address,
                $request->validated()
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
