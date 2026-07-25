<?php

namespace App\Http\Controllers\Admin;

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
        $this->couponService->create($request->validated());

        return redirect()
            ->route('admin.coupons.index')
            ->with('success', __('messages.created_successfully'));
    }

    public function edit(Coupon $coupon)
    {
        return view('admin.coupons.edit', compact('coupon'));
    }

    public function update(UpdateCouponRequest $request, Coupon $coupon)
    {
        $this->couponService->update(
            $coupon,
            $request->validated()
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
