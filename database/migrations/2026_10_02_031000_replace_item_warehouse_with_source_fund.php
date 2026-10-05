<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropForeign(['warehouse_id']);
        });

        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn('warehouse_id');
        });

        Schema::table('items', function (Blueprint $table) {
            $table->foreignId('supplier_id')
                ->nullable()
                ->after('unit_id')
                ->constrained('suppliers')
                ->nullOnDelete();
        });

        Schema::dropIfExists('warehouses');
    }

    public function down(): void
    {
        Schema::create('warehouses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('location')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::table('items', function (Blueprint $table) {
            $table->dropForeign(['supplier_id']);
        });

        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn('supplier_id');
        });

        Schema::table('items', function (Blueprint $table) {
            $table->foreignId('warehouse_id')
                ->nullable()
                ->after('unit_id')
                ->constrained('warehouses')
                ->restrictOnDelete();
        });
    }
};
