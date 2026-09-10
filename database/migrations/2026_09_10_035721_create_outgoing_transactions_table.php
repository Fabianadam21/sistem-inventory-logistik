<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('outgoing_transactions', function (Blueprint $table) {
            $table->id();

            $table->string('transaction_number')->unique();

            $table->date('date');

            $table->foreignId('department_id')
                ->constrained('departments')
                ->restrictOnDelete();

            $table->text('description')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('outgoing_transactions');
    }
};