<?php

use App\Models\PackageCategory;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('package_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->timestamps();
        });

        $timestamp = now();

        DB::table('package_categories')->insert(
            collect(PackageCategory::DEFAULT_CATEGORY_NAMES)
                ->map(fn (string $name) => [
                    'name' => $name,
                    'slug' => Str::slug($name),
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp,
                ])
                ->all()
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('package_categories');
    }
};
