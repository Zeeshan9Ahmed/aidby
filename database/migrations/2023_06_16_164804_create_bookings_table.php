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
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('category_id')->references('id')->on('categories')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('sub_category_id')->references('id')->on('categories')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('per_hour_rate');
            $table->date('date');
            $table->time('time');
            $table->enum('license', ['0', '1'])->nullable();
            $table->enum('rating', ['1', '2', '3', '4', '5']);
            $table->enum('payment_method', ['cash', 'card']);
            $table->longText('additional_information');
            $table->enum('status', ['pending', 'completed', 'in-progress', 'rejected'])->default('pending');
            $table->integer('completed_by')->nullable();
            $table->timestamps();
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
