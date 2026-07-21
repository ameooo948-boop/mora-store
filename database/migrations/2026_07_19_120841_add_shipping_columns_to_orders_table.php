<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {

            $table->string('shipping_name')
                ->after('status');

            $table->string('shipping_phone', 20)
                ->after('shipping_name');

            $table->string('shipping_country')
                ->after('shipping_phone');

            $table->string('shipping_state')
                ->after('shipping_country');

            $table->string('shipping_city')
                ->after('shipping_state');

            $table->string('shipping_address')
                ->after('shipping_city');

            $table->string('shipping_postal_code')
                ->nullable()
                ->after('shipping_address');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {

            $table->dropColumn([

                'shipping_name',

                'shipping_phone',

                'shipping_country',

                'shipping_state',

                'shipping_city',

                'shipping_address',

                'shipping_postal_code',

            ]);
        });
    }
};
