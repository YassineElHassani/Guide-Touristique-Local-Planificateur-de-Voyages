<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('itinerary_destination', function (Blueprint $table) {
            $table->id();
            $table->foreignId('itineraries_id')->constrained('itineraries')->onDelete('cascade');
            $table->foreignId('destinations_id')->constrained('destinations')->onDelete('cascade');
            $table->integer('day')->nullable();
            $table->integer('order')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('itinerary_destinations');
    }
};
