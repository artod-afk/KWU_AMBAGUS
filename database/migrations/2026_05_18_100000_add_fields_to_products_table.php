<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Tambah category_id jika belum ada
            if (!Schema::hasColumn('products', 'category_id')) {
                $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null')->after('id');
            }
            // Tambah harga beli jika belum ada
            if (!Schema::hasColumn('products', 'purchase_price')) {
                $table->decimal('purchase_price', 15, 2)->default(0)->after('price');
            }
            // Tambah harga jual jika belum ada
            if (!Schema::hasColumn('products', 'selling_price')) {
                $table->decimal('selling_price', 15, 2)->default(0)->after('purchase_price');
            }
            // Tambah untung jika belum ada
            if (!Schema::hasColumn('products', 'profit')) {
                $table->decimal('profit', 15, 2)->default(0)->after('selling_price');
            }
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn(['category_id', 'purchase_price', 'selling_price', 'profit']);
        });
    }
};
