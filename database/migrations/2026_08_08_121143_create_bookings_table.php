<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_code')->unique();
            $table->foreignId('customer_id')->constrained()->restrictOnDelete();
            $table->foreignId('tour_package_id')->constrained()->restrictOnDelete();
            $table->foreignId('tour_package_availability_id')->constrained('tour_package_availabilities')->restrictOnDelete();
            $table->foreignId('promotion_id')->nullable()->constrained()->nullOnDelete();

            // Participant counts
            $table->unsignedInteger('adult_count')->default(0);
            $table->unsignedInteger('child_count')->default(0);
            $table->unsignedInteger('infant_count')->default(0);

            // Server-calculated price snapshot (never trust frontend totals)
            $table->decimal('price_adult', 12, 2);
            $table->decimal('price_child', 12, 2);
            $table->decimal('price_infant', 12, 2);
            $table->decimal('addons_total', 12, 2)->default(0);
            $table->decimal('subtotal', 12, 2);
            $table->decimal('discount_amount', 12, 2)->default(0);
            $table->decimal('total_amount', 12, 2);
            $table->decimal('amount_paid', 12, 2)->default(0);

            $table->enum('status', ['pending', 'confirmed', 'cancelled', 'completed'])->default('pending');
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index('status');
            $table->index(['tour_package_availability_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
