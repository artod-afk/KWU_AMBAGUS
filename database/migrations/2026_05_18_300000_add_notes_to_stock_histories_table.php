<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('stock_histories', function (Blueprint $table) {
            if (!Schema::hasColumn('stock_histories', 'notes')) {
                $table->string('notes')->nullable()->after('quantity');
            }
            if (!Schema::hasColumn('stock_histories', 'source')) {
                // source: 'manual_add', 'manual_edit', 'sale', 'purchase'
                $table->string('source')->default('manual_add')->after('notes');
            }
        });
    }

    public function down(): void
    {
        Schema::table('stock_histories', function (Blueprint $table) {
            $table->dropColumn(['notes', 'source']);
        });
    }
};
