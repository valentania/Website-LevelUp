<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Make `complexity` nullable so UMKM can omit it (admin determines during review).
     */
    public function up(): void
    {
        // Clear any auto-inserted 'easy' defaults on missions still awaiting admin review
        DB::table('missions')
            ->where('status', 'pending_review')
            ->where('complexity', 'easy')
            ->update(['complexity' => null]);

        Schema::table('missions', function (Blueprint $table) {
            $table->string('complexity')->nullable()->default(null)->change();
        });
    }

    public function down(): void
    {
        DB::table('missions')->whereNull('complexity')->update(['complexity' => 'easy']);

        Schema::table('missions', function (Blueprint $table) {
            $table->string('complexity')->nullable(false)->default('easy')->change();
        });
    }
};
