<?php

namespace App\DTOs\Profile;

use Illuminate\Http\UploadedFile;

final readonly class UpdateProfileData
{
    public function __construct(
        public string $name,
        public string $email,
        public ?UploadedFile $avatar = null,
    ) {}
}
