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
            $table->string('name');
            $table->string('username')->unique();
            $table->string('password');
            $table->string('device_token')->nullable();
            $table->boolean('is_admin')->default(false);
            $table->boolean('status')->default(true);
            $table->string('customer')->nullable();
            $table->string('customer_phone')->nullable();
            $table->boolean('sold')->default(false)->comment('售出狀態');
            $table->integer('sold_price')->nullable()->comment('售出金額');
            $table->timestamp('expiration')->nullable()->comment('到期日');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->foreignId('current_team_id')->nullable();
            $table->string('profile_photo_path', 2048)->nullable();
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
