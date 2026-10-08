<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\OrderStatus;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->references('id')->on('users')->setNullOnDelete();
            $table->foreignId('driver_id')->nullable()->references('id')->on('users')->setNullOnDelete();
            $table->foreignId('store_id')->constrained()->restrictOnDelete();
            $table->enum('status', array_column(OrderStatus::cases(), 'value'))
                    ->default(OrderStatus::PENDING->value);
            $table->timestamp('assigned_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
