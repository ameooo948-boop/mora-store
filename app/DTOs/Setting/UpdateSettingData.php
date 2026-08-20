<?php

namespace App\DTOs\Setting;

use Illuminate\Http\UploadedFile;

readonly class UpdateSettingData
{
    public function __construct(
        public string $siteName,
        public ?string $siteDescription,
        public ?UploadedFile $siteLogo,
        public ?UploadedFile $siteFavicon,
        public string $currency,
        public string $currencySymbol,
        public float $shippingCost,
        public float $taxPercentage,
        public ?string $email,
        public ?string $phone,
        public ?string $address,
        public ?string $facebook,
        public ?string $instagram,
        public ?string $linkedin,
        public bool $maintenanceMode,
    ) {}
}
