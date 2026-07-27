<?php

namespace App\Enums;

enum PaymentMethod: string
{
    case CashOnDelivery = 'cash_on_delivery';

    case Stripe = 'stripe';

    case Paypal = 'paypal';

    public function label(): string
    {
        return match ($this) {

            self::CashOnDelivery => 'Cash on Delivery',

            self::Stripe => 'Stripe',

            self::Paypal => 'PayPal',
        };
    }

    public function icon(): string
    {
        return match ($this) {

            self::CashOnDelivery => 'bi-cash-stack',

            self::Stripe => 'bi-credit-card',

            self::Paypal => 'bi-paypal',
        };
    }

    public function description(): string
    {
        return match ($this) {

            self::CashOnDelivery => 'Pay when your order is delivered.',

            self::Stripe => 'Secure payment using your credit or debit card.',

            self::Paypal => 'Pay using your PayPal account.',
        };
    }

    public function badge(): string
    {
        return match ($this) {

            self::CashOnDelivery => 'secondary',

            self::Stripe => 'primary',

            self::Paypal => 'info',
        };
    }
}
