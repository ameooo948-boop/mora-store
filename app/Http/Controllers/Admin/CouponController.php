<?php

namespace App\Http\Controllers\Admin;

use App\DTOs\Coupon\CreateCouponData;
use App\DTOs\Coupon\UpdateCouponData;
use App\Enums\CouponType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCouponRequest;
use App\Http\Requests\Admin\UpdateCouponRequest;
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
        $coupons = $this->couponService->paginate(
            $request->all()
        );

        return view('admin.coupons.index', compact('coupons'));
    }

    public function show(Coupon $coupon)
    {
        return view('admin.coupons.show', compact('coupon'));
    }

    public function create()
    {
        return view('admin.coupons.create');
    }

    public function store(StoreCouponRequest $request)
    {
        $this->couponService->create(
            new CreateCouponData(
                code: $request->string('code')->value(),
                type: $request->enum('type', CouponType::class),
                value: (float) $request->input('value'),
                minimumAmount: $request->filled('minimum_amount')
                    ? (float) $request->input('minimum_amount')
                    : null,
                maximumDiscount: $request->filled('maximum_discount')
                    ? (float) $request->input('maximum_discount')
                    : null,
                usageLimit: $request->filled('usage_limit')
                    ? $request->integer('usage_limit')
                    : null,
                startsAt: $request->date('starts_at'),
                expiresAt: $request->date('expires_at'),
                status: $request->boolean('status'),
            )
        );

        return redirect()
            ->route('admin.coupons.index')
            ->with('success', __('messages.created_successfully'));
    }

    public function edit(Coupon $coupon)
    {
        return view('admin.coupons.edit', compact('coupon'));
    }

    public function update(
        UpdateCouponRequest $request,
        Coupon $coupon
    ) {
        $this->couponService->update(
            $coupon,
            new UpdateCouponData(
                code: $request->string('code')->value(),
                type: $request->enum('type', CouponType::class),
                value: (float) $request->input('value'),
                minimumAmount: $request->filled('minimum_amount')
                    ? (float) $request->input('minimum_amount')
                    : null,
                maximumDiscount: $request->filled('maximum_discount')
                    ? (float) $request->input('maximum_discount')
                    : null,
                usageLimit: $request->filled('usage_limit')
                    ? $request->integer('usage_limit')
                    : null,
                startsAt: $request->date('starts_at'),
                expiresAt: $request->date('expires_at'),
                status: $request->boolean('status'),
            )
        );

        return redirect()
            ->route('admin.coupons.index')
            ->with('success', __('messages.updated_successfully'));
    }

    public function destroy(Coupon $coupon)
    {
        $this->couponService->delete($coupon);

        return redirect()
            ->route('admin.coupons.index')
            ->with('success', __('messages.deleted_successfully'));
    }
}
