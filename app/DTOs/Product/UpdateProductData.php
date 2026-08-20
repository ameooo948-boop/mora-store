<?php

namespace App\DTOs\Product;

use Illuminate\Http\UploadedFile;

final readonly class UpdateProductData
{
    public function __construct(
        public int $categoryId,
        public int $brandId,
        public string $name,
        public ?string $description,
        public float $price,
        public ?float $salePrice,
        public int $quantity,
        public bool $status,
        public bool $featured,
        public int $sortOrder,
        /** @var array<UploadedFile> */
        public array $images = [],
    ) {}
}
