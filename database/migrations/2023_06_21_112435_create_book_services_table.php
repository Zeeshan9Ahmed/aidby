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
        Schema::create('book_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('user_service_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('service_id')->references('id')->on('services')->onDelete('cascade')->onUpdate('cascade');
            $table->date('start_date');
            $table->date('end_date');
            $table->time('time');
            $table->enum('payment_method', ['cash', 'card']);
            $table->longText('additional_information');
            $table->enum('status', ['pending', 'completed', 'in-progress', 'rejected'])->default('pending');
            $table->enum('is_other_address', ['0', '1'])->default('0');
            $table->string('location')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_services');
    }
};
