<?php

namespace App\DTOs\Category;

use Illuminate\Http\UploadedFile;

readonly class CreateCategoryData
{
    public function __construct(
        public string $name,
        public ?string $description,
        public ?UploadedFile $image,
        public ?int $parentId,
        public bool $status,
        public int $sortOrder,
    ) {}
}
