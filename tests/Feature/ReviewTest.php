<?php

namespace Tests\Feature;

use App\Enums\ReviewStatus;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use App\Services\ReviewService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class ReviewTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_review_for_product(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $product = Product::factory()
            ->withRelations()
            ->create([
                'price' => 100,
                'sale_price' => null,
                'quantity' => 10,
                'status' => true,
            ]);

        $review = Review::create([
            'product_id' => $product->id,
            'user_id' => $user->id,
            'rating' => 5,
            'comment' => 'Excellent product.',
            'status' => ReviewStatus::Pending,
        ]);

        $this->assertDatabaseHas('reviews', [
            'id' => $review->id,
            'product_id' => $product->id,
            'user_id' => $user->id,
            'rating' => 5,
            'comment' => 'Excellent product.',
            'status' => ReviewStatus::Pending->value,
        ]);
    }

    public function test_user_cannot_review_same_product_twice(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $product = Product::factory()
            ->withRelations()
            ->create([
                'price' => 100,
                'sale_price' => null,
                'quantity' => 10,
                'status' => true,
            ]);

        Review::create([
            'product_id' => $product->id,
            'user_id' => $user->id,
            'rating' => 5,
            'comment' => 'Excellent product.',
            'status' => ReviewStatus::Pending,
        ]);

        $this->expectException(\Illuminate\Database\QueryException::class);

        Review::create([
            'product_id' => $product->id,
            'user_id' => $user->id,
            'rating' => 4,
            'comment' => 'Second review.',
            'status' => ReviewStatus::Pending,
        ]);
    }

    public function test_user_cannot_review_product_without_purchasing_it(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $product = Product::factory()
            ->withRelations()
            ->create([
                'price' => 100,
                'sale_price' => null,
                'quantity' => 10,
                'status' => true,
            ]);

        $this->expectException(AuthorizationException::class);

        $this->expectExceptionMessage(
            'You must purchase this product before reviewing it.'
        );

        app(ReviewService::class)->create(
            $product,
            $user,
            5,
            'Excellent product.'
        );
    }

    public function test_updating_review_resets_approval_data(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $product = Product::factory()
            ->withRelations()
            ->create([
                'price' => 100,
                'sale_price' => null,
                'quantity' => 10,
                'status' => true,
            ]);

        $admin = User::factory()->create();

        $review = Review::create([
            'product_id' => $product->id,
            'user_id' => $user->id,
            'rating' => 5,
            'comment' => 'Old review.',
            'status' => ReviewStatus::Approved,
            'approved_by' => $admin->id,
            'approved_at' => now(),
        ]);

        app(\App\Services\ReviewService::class)->update(
            $review,
            3,
            'Updated review.'
        );

        $review->refresh();

        $this->assertSame(3, $review->rating);
        $this->assertSame('Updated review.', $review->comment);
        $this->assertSame(
            ReviewStatus::Pending,
            $review->status
        );
        $this->assertNull($review->approved_by);
        $this->assertNull($review->approved_at);
    }

    public function test_admin_can_approve_review(): void
    {
        Notification::fake();

        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $admin = User::factory()->create();

        $product = Product::factory()
            ->withRelations()
            ->create([
                'price' => 100,
                'sale_price' => null,
                'quantity' => 10,
                'status' => true,
            ]);

        $review = Review::create([
            'product_id' => $product->id,
            'user_id' => $user->id,
            'rating' => 5,
            'comment' => 'Excellent product.',
            'status' => ReviewStatus::Pending,
        ]);

        $this->actingAs($admin);

        $result = app(\App\Services\ReviewService::class)
            ->approve($review);

        $review->refresh();

        $this->assertTrue($result);

        $this->assertSame(
            ReviewStatus::Approved,
            $review->status
        );

        $this->assertSame(
            $admin->id,
            $review->approved_by
        );

        $this->assertNotNull(
            $review->approved_at
        );

        Notification::assertSentTo(
            $user,
            \App\Notifications\ReviewApprovedNotification::class
        );
    }

    public function test_admin_can_reject_review(): void
    {
        $admin = User::factory()->create();

        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $product = Product::factory()
            ->withRelations()
            ->create([
                'price' => 100,
                'sale_price' => null,
                'quantity' => 10,
                'status' => true,
            ]);

        $review = Review::create([
            'product_id' => $product->id,
            'user_id' => $user->id,
            'rating' => 5,
            'comment' => 'Excellent product.',
            'status' => ReviewStatus::Pending,
            'approved_by' => $admin->id,
            'approved_at' => now(),
        ]);

        $result = app(\App\Services\ReviewService::class)
            ->reject($review);

        $review->refresh();

        $this->assertTrue($result);

        $this->assertSame(
            ReviewStatus::Rejected,
            $review->status
        );

        $this->assertNull($review->approved_by);

        $this->assertNull($review->approved_at);
    }
}
