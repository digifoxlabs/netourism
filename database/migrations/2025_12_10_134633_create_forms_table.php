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
          Schema::create('forms', function (Blueprint $table) {
            $table->id();
            $table->string('name');                // Admin-friendly name
            $table->string('slug')->unique();      // Used to reference form in code/routes
            $table->text('description')->nullable();
            $table->text('success_message')->nullable();
            $table->string('redirect_url')->nullable(); // Optional redirect after submit
            $table->boolean('is_active')->default(true);
            $table->string('confirmation_email_subject')->nullable();
            $table->boolean('auto_email_confirmation')->default(false);
            $table->text('confirmation_email_template')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forms');
    }
};
