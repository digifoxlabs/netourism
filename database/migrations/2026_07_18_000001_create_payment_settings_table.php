<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_settings', function (Blueprint $table) {
            $table->id();
            $table->boolean('enabled')->default(false);
            $table->string('environment')->default('demo');
            $table->string('demo_url')->default('https://test.payu.in/_payment');
            $table->string('live_url')->default('https://secure.payu.in/_payment');
            $table->string('alt_id_demo_url')->default('https://apitest.payu.in/card/altid');
            $table->string('alt_id_live_url')->default('https://api.payu.in/card/altid');
            $table->string('merchant_key')->nullable();
            $table->text('merchant_salt')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_settings');
    }
};
