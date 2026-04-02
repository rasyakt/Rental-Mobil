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
        Schema::create('vehicle_tracking', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('bookings')->onDelete('cascade');
            $table->foreignId('vehicle_id')->constrained('vehicles')->onDelete('restrict');
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            $table->integer('speed')->default(0);
            $table->integer('altitude')->nullable();
            $table->string('address')->nullable();
            $table->json('route_data')->nullable();
            $table->timestamps();

            // Use regular index instead of spatial index
            $table->index(['latitude', 'longitude']);
            $table->index(['booking_id', 'created_at']);
        });

        Schema::create('maintenance_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id')->constrained('vehicles')->onDelete('restrict');
            $table->enum('type', ['maintenance', 'repair', 'inspection', 'service']);
            $table->date('date');
            $table->integer('km_before');
            $table->integer('km_after')->nullable();
            $table->text('description');
            $table->text('work_done');
            $table->decimal('cost', 12, 2);
            $table->string('vendor')->nullable();
            $table->text('notes')->nullable();
            $table->date('next_maintenance_date')->nullable();
            $table->integer('next_maintenance_km')->nullable();
            $table->enum('status', ['scheduled', 'in_progress', 'completed', 'cancelled'])->default('scheduled');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['vehicle_id', 'date']);
            $table->index('status');
        });

        Schema::create('vehicle_damages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('bookings')->onDelete('restrict');
            $table->foreignId('vehicle_id')->constrained('vehicles')->onDelete('restrict');
            $table->enum('severity', ['minor', 'moderate', 'severe', 'critical']);
            $table->text('description');
            $table->string('photo_path')->nullable();
            $table->decimal('estimated_cost', 12, 2)->nullable();
            $table->decimal('actual_cost', 12, 2)->nullable();
            $table->enum('status', ['reported', 'assessed', 'being_repaired', 'repaired', 'disputed'])->default('reported');
            $table->text('notes')->nullable();
            $table->dateTime('reported_at');
            $table->dateTime('resolved_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['vehicle_id', 'booking_id']);
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_damages');
        Schema::dropIfExists('maintenance_logs');
        Schema::dropIfExists('vehicle_tracking');
    }
};
