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
            $table->string('booking_number')->unique();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('restrict');
            $table->foreignId('vehicle_id')->constrained('vehicles')->onDelete('restrict');
            $table->foreignId('driver_id')->nullable()->constrained('drivers')->onDelete('set null');
            $table->foreignId('pickup_branch_id')->constrained('branches')->onDelete('restrict');
            $table->foreignId('return_branch_id')->constrained('branches')->onDelete('restrict');
            $table->dateTime('pickup_date');
            $table->dateTime('return_date');
            $table->enum('rental_type', ['daily', 'weekly', 'monthly'])->default('daily');
            $table->boolean('with_driver')->default(false);
            $table->text('pickup_address');
            $table->text('return_address');
            $table->decimal('total_price', 12, 2);
            $table->decimal('tax', 12, 2)->default(0);
            $table->decimal('additional_charges', 12, 2)->default(0);
            $table->decimal('discount', 12, 2)->default(0);
            $table->decimal('final_price', 12, 2);
            $table->enum('status', ['pending', 'confirmed', 'active', 'completed', 'cancelled'])->default('pending');
            $table->text('notes')->nullable();
            $table->text('admin_notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('booking_number');
            $table->index('customer_id');
            $table->index('status');
            $table->index('pickup_date');
        });

        Schema::create('booking_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('bookings')->onDelete('cascade');
            $table->decimal('price_per_unit', 12, 2);
            $table->integer('quantity');
            $table->string('description');
            $table->decimal('subtotal', 12, 2);
            $table->timestamps();
        });

        Schema::create('bookings_amenities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('bookings')->onDelete('cascade');
            $table->string('amenity_name');
            $table->decimal('price', 12, 2);
            $table->integer('quantity')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings_amenities');
        Schema::dropIfExists('booking_details');
        Schema::dropIfExists('bookings');
    }
};
