<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->boolean('payment_required')->default(false)->after('fee');
            $table->decimal('payment_amount', 10, 2)->nullable()->after('payment_required');
        });

        Schema::table('packages', function (Blueprint $table) {
            $table->boolean('payment_required')->default(false)->after('form_id');
            $table->decimal('payment_amount', 10, 2)->nullable()->after('payment_required');
        });

        Schema::table('form_submissions', function (Blueprint $table) {
            $table->foreignId('package_id')->nullable()->after('event_id')->constrained('packages')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('form_submissions', function (Blueprint $table) {
            $table->dropConstrainedForeignId('package_id');
        });

        Schema::table('packages', function (Blueprint $table) {
            $table->dropColumn(['payment_required', 'payment_amount']);
        });

        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn(['payment_required', 'payment_amount']);
        });
    }
};
