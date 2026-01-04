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
        Schema::create('form_fields', function (Blueprint $table) {
            $table->id();
            $table->foreignId('form_id')->constrained()->onDelete('cascade');
            $table->string('section_title')->nullable();

            $table->string('label');              // "Full Name"
            $table->string('name');               // "full_name" - used as input name
            $table->string('type');               // text, email, textarea, select, radio, checkbox, number, date, tel, etc.
            $table->string('placeholder')->nullable();
            $table->text('help_text')->nullable();

            $table->boolean('required')->default(false);
            $table->json('options')->nullable();  // for select/radio/checkbox choices
            $table->json('validation_rules')->nullable(); // e.g. ["min:3","max:50"]

            $table->integer('sort_order')->default(0);
            $table->string('width')->default('full'); // full, half, third, etc if you want layout control later

            $table->boolean('conditional_enabled')->default(false);
            $table->string('conditional_field')->nullable();
            $table->string('conditional_operator', 20)->nullable();
            $table->string('conditional_value')->nullable();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_fields');
    }
};
