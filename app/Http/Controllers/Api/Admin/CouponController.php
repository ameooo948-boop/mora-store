<?php

namespace App\Http\Controllers\Api\Admin;

use App\DTOs\Coupon\CreateCouponData;
use App\DTOs\Coupon\UpdateCouponData;
use App\Enums\CouponType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCouponRequest;
use App\Http\Requests\Admin\UpdateCouponRequest;
use App\Http\Resources\CouponResource;
use App\Models\Coupon;
use App\Services\CouponService;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function __construct(
        protected CouponService $couponService
    ) {}

    public function index(Request $request)
    {
        $coupons = $this->couponService->paginate($request->all());

        return response()->json([
            'coupons' => CouponResource::collection($coupons),
            'meta' => [
                'current_page' => $coupons->currentPage(),
                'last_page' => $coupons->lastPage(),
                'total' => $coupons->total(),
            ],
        ]);
    }

    public function show(Coupon $coupon)
    {
        return response()->json([
            'coupon' => new CouponResource($coupon),
        ]);
    }

    public function store(StoreCouponRequest $request)
    {
        $coupon = $this->couponService->create(
            new CreateCouponData(
                code: $request->string('code')->value(),
                type: $request->enum('type', CouponType::class),
                value: (float) $request->input('value'),
                minimumAmount: $request->filled('minimum_amount') ? (float) $request->input('minimum_amount') : null,
                maximumDiscount: $request->filled('maximum_discount') ? (float) $request->input('maximum_discount') : null,
                usageLimit: $request->filled('usage_limit') ? $request->integer('usage_limit') : null,
                startsAt: $request->date('starts_at'),
                expiresAt: $request->date('expires_at'),
                status: $request->boolean('status'),
            )
        );

        return response()->json([
            'message' => __('messages.created_successfully'),
            'coupon' => new CouponResource($coupon),
        ], 201);
    }

    public function update(
        UpdateCouponRequest $request,
        Coupon $coupon
    ) {
        $coupon = $this->couponService->update(
            $coupon,
            new UpdateCouponData(
                code: $request->string('code')->value(),
                type: $request->enum('type', CouponType::class),
                value: (float) $request->input('value'),
                minimumAmount: $request->filled('minimum_amount') ? (float) $request->input('minimum_amount') : null,
                maximumDiscount: $request->filled('maximum_discount') ? (float) $request->input('maximum_discount') : null,
                usageLimit: $request->filled('usage_limit') ? $request->integer('usage_limit') : null,
                startsAt: $request->date('starts_at'),
                expiresAt: $request->date('expires_at'),
                status: $request->boolean('status'),
            )
        );

        return response()->json([
            'message' => __('messages.updated_successfully'),
            'coupon' => new CouponResource($coupon),
        ]);
    }

    public function destroy(Coupon $coupon)
    {
        $this->couponService->delete($coupon);

        return response()->json([
            'message' => __('messages.deleted_successfully'),
        ]);
    }
}
