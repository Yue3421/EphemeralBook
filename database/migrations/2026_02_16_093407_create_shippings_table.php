<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shippings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaction_id')
                ->constrained()
                ->cascadeOnDelete(); // Perbaikan
            $table->text('address');
            $table->string('courier');
            $table->string('tracking_number')->nullable();
            $table->foreignId('shipped_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete(); // Perbaikan untuk SET NULL
            $table->timestamp('shipped_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shippings');
    }
};