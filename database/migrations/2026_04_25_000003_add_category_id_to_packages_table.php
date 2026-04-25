<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->foreignId('category_id')
                ->nullable()
                ->after('subtitle')
                ->constrained('package_categories')
                ->nullOnDelete();
        });

        $indiaTripCategoryId = DB::table('package_categories')
            ->where('slug', Str::slug('India Trip'))
            ->value('id');

        if ($indiaTripCategoryId) {
            DB::table('packages')
                ->whereNull('category_id')
                ->update(['category_id' => $indiaTripCategoryId]);
        }
    }

    public function down(): void
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->dropConstrainedForeignId('category_id');
        });
    }
};
