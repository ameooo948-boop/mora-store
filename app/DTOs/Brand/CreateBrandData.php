<?php

namespace App\DTOs\Brand;

use Illuminate\Http\UploadedFile;

readonly class CreateBrandData
{
    public function __construct(
        public string $name,
        public ?string $description,
        public ?UploadedFile $logo,
        public bool $status,
        public int $sortOrder,
    ) {}
}
