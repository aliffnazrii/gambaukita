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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('booking_id');
            $table->string('type'); // e.g., "deposit" or "balance"
            $table->decimal('amount', 10, 2); // Amount for the payment
            $table->string('status'); // e.g., "pending", "completed"
            $table->string('transaction_id')->nullable(); // Stripe transaction ID or payment intent ID
            $table->string('payment_method')->nullable(); // e.g., "card", "fpx"
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
