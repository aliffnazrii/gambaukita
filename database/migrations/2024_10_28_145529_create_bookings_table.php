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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('package_id');
            $table->string('venue');
            $table->date('event_date');
            $table->time('event_time');
            $table->string('remark')->nullable();
            $table->string('acceptance_status')->nullable();
            $table->string('progress_status')->nullable();
            $table->integer('deposit_percentage');
            $table->decimal('total_price', 10, 2);
            $table->timestamps();

            // Optional: Add foreign key constraints if 'users' and 'packages' tables exist
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('package_id')->references('id')->on('packages')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};