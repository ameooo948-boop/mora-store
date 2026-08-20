<?php

namespace App\DTOs\Review;

final readonly class CreateReviewData
{
    public function __construct(
        public int $rating,
        public string $comment,
    ) {}
}
