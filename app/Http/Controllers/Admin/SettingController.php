<?php

namespace App\Http\Controllers\Admin;

use App\DTOs\Setting\UpdateSettingData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Setting\UpdateSettingRequest;
use App\Services\SettingService;

class SettingController extends Controller
{
    public function __construct(
        protected SettingService $service,
    ) {}

    public function edit()
    {
        return view(
            'admin.settings.edit',
            [

                'settings' => $this->service
                    ->all(),

            ]
        );
    }

    public function update(
        UpdateSettingRequest $request,
    ) {

        $this->service->update(
            new UpdateSettingData(
                siteName: $request->string('site_name')->value(),
                siteDescription: $request->input('site_description'),
                siteLogo: $request->file('site_logo'),
                siteFavicon: $request->file('site_favicon'),
                currency: $request->string('currency')->value(),
                currencySymbol: $request->string('currency_symbol')->value(),
                shippingCost: (float) $request->input('shipping_cost'),
                taxPercentage: (float) $request->input('tax_percentage'),
                email: $request->input('email'),
                phone: $request->input('phone'),
                address: $request->input('address'),
                facebook: $request->input('facebook'),
                instagram: $request->input('instagram'),
                linkedin: $request->input('linkedin'),
                maintenanceMode: $request->boolean('maintenance_mode'),
            )
        );

        return back()->with(

            'success',

            'Settings updated successfully.'

        );
    }
}
