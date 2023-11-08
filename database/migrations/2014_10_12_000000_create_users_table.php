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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('profile_image')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('driving_license')->nullable();
            $table->string('location')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->enum('type', ['user','service','rider']);
            $table->enum('is_profile_complete', ['0','1'])->default('0');
            $table->enum('device_type', ['ios','android','web'])->nullable();
            $table->string('device_token')->nullable();
            $table->enum('social_type', ['google','facebook','twitter','instagram','apple','phone'])->nullable();
            $table->string('social_token')->nullable();
            $table->integer('verified_code')->nullable();
            $table->enum('is_verified', ['0','1'])->default('0');
            $table->enum('is_social', ['0','1'])->default('0');
            $table->enum('is_active', ['0','1'])->default('1');
            $table->enum('is_blocked', ['0','1'])->default('0');
            $table->string('customer_id')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
