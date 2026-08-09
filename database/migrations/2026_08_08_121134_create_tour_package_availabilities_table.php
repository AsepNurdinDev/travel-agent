<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tour_package_availabilities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tour_package_id')->constrained()->cascadeOnDelete();
            $table->date('departure_date');
            $table->date('return_date');
            $table->unsignedInteger('quota');
            $table->unsignedInteger('seats_booked')->default(0);
            $table->decimal('price_adult_override', 12, 2)->nullable();
            $table->decimal('price_child_override', 12, 2)->nullable();
            $table->decimal('price_infant_override', 12, 2)->nullable();
            $table->enum('status', ['open', 'closed', 'full', 'cancelled'])->default('open');
            $table->timestamps();

            $table->index(['tour_package_id', 'departure_date']);
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tour_package_availabilities');
    }
};
