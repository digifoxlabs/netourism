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
     Schema::create('event_registrations', function (Blueprint $table) {
            $table->id();

            // Event meta (optional but useful if you reuse table)
            $table->string('event_code')->default('alfresco_2_2025');
            $table->string('event_name')->default('Alfresco 2.0 - Embracing the Call of the Wild Kaziranga');

            // 1. Personal Details
            $table->string('full_name');
            $table->string('email');
            $table->string('mobile');
            $table->string('city_state');
            $table->date('date_of_birth');
            $table->string('emergency_contact_person');
            $table->string('emergency_contact_number');

            // 2. Event & Ride Details
            $table->enum('mode_of_transport', ['motorcycle', 'pillion', 'other']);
            $table->string('motorcycle_make_model')->nullable();
            $table->string('license_plate_number')->nullable();
            $table->boolean('is_pillion')->default(false);
            $table->string('primary_rider_name')->nullable();
            $table->enum('accommodation_preference', ['tent_sharing', 'separate_tent']);
            $table->text('allergies_dietary')->nullable();

            // 3. Payment & Confirmation
            $table->enum('payment_method', ['upi', 'bank_transfer']);
            $table->string('transaction_id');
            $table->date('payment_date');

            // 4. Terms & Conditions
            $table->boolean('terms_accepted')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_registrations');
    }
};
