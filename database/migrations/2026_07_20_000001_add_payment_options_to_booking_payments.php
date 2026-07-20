<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->json('payment_options')->nullable()->after('payment_amount');
        });

        Schema::table('packages', function (Blueprint $table) {
            $table->json('payment_options')->nullable()->after('payment_amount');
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->string('payment_label')->nullable()->after('productinfo');
            $table->string('payment_type')->default('full')->after('payment_label');
            $table->text('payment_description')->nullable()->after('payment_type');
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn(['payment_label', 'payment_type', 'payment_description']);
        });

        Schema::table('packages', function (Blueprint $table) {
            $table->dropColumn('payment_options');
        });

        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('payment_options');
        });
    }
};
