<?php

namespace App\Http\Controllers\Admin;

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

            $request->validated()

        );

        return back()->with(

            'success',

            'Settings updated successfully.'

        );
    }
}
