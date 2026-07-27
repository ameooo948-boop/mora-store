<?php

use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {


            $table->id();
            $table->foreignId('order_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('transaction_id')
                ->nullable();

            $table->decimal('amount', 10, 2);

            $table->string('payment_method')
                ->default(PaymentMethod::CashOnDelivery->value);

            $table->string('status')
                ->default(PaymentStatus::Pending->value);

            $table->timestamp('paid_at')
                ->nullable();

            $table->timestamps();

            $table->index('status');

            $table->index('payment_method');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
