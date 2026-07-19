<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('form_submission_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('event_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('package_id')->nullable()->constrained()->nullOnDelete();
            $table->string('txnid')->unique();
            $table->string('status')->default('pending');
            $table->decimal('amount', 10, 2);
            $table->string('currency', 3)->default('INR');
            $table->string('productinfo');
            $table->string('firstname')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('payu_payment_id')->nullable();
            $table->string('payu_status')->nullable();
            $table->json('gateway_request')->nullable();
            $table->json('gateway_response')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamp('failed_at')->nullable();
            $table->timestamp('refunded_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
