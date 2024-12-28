<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->Integer('role_id');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('otp')->nullable();
            $table->string('phone')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('country')->nullable();
            $table->Text('image')->nullable();
            $table->double('rating')->default(0.0);
            $table->String('location')->nullable();
            $table->String('lat')->nullable();
            $table->String('lng')->nullable();
            $table->string('api_token')->nullable();
            $table->string('fcm_token')->nullable();
            $table->string('provider_id')->nullable();
            $table->string('provider_name')->nullable();
            $table->string('access_token')->nullable();
            $table->TinyInteger('is_push_notification')->default(1);
            $table->TinyInteger('status')->default(0);
            $table->TinyInteger('is_verified')->default(0);            
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
