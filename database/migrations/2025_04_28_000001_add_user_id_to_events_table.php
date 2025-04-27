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
        Schema::table('events', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->after('id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->integer('capacity')->default(20)->after('price');
            $table->text('requirements')->nullable()->after('capacity');
            $table->text('itinerary')->nullable()->after('requirements');
            $table->boolean('is_featured')->default(false)->after('itinerary');
            $table->boolean('is_private')->default(false)->after('is_featured');
            $table->string('status')->default('published')->after('is_private');
            $table->unsignedBigInteger('category_id')->nullable()->after('status');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
            $table->float('duration')->default(2)->after('category_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['category_id']);
            $table->dropColumn([
                'user_id', 
                'capacity', 
                'requirements', 
                'itinerary', 
                'is_featured', 
                'is_private', 
                'status', 
                'category_id',
                'duration'
            ]);
        });
    }
};
