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
    Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->string('slug')->unique();
            $table->foreignId('form_id')->nullable()->constrained('forms')->nullOnDelete();
            $table->string('photo_path')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->enum('status', ['active', 'upcoming', 'expired'])->default('upcoming');
            //$table->boolean('is_active')->default(true);
            $table->text('description')->nullable();
            $table->string('fee')->nullable();

            $table->date('submission_start_date')->nullable();
            $table->date('submission_end_date')->nullable();

            // Advanced submission controls
            $table->boolean('auto_close_submission')->default(false);
            $table->unsignedInteger('submission_limit')->default(100);
            $table->boolean('show_remaining_seats')->default(false);

            $table->string('admin_confirmation_email_subject')->nullable();
            $table->boolean('admin_confirmation_enabled')->default(false);
            $table->longText('admin_confirmation_email_template')->nullable();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
