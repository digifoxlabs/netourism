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
        Schema::create('packages', function (Blueprint $table) {
            $table->id();

            // Basic info
            $table->string('name');
            $table->string('subtitle')->nullable();

            // Rich content
            $table->longText('description')->nullable();

            // Duration
            $table->unsignedInteger('duration_days')->nullable();

            // Images
            $table->string('thumbnail_image')->nullable(); // card view
            $table->string('hero_image')->nullable();      // detail header

            // Itinerary stored as JSON
            $table->json('itinerary')->nullable();

            //Add Form
             $table->foreignId('form_id')->nullable()->constrained('forms')->nullOnDelete();

            // Status
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
