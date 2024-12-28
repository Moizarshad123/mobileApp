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
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->Integer("user_id")->nullable();
            $table->String("business_name")->nullable();
            $table->String("category")->nullable();
            $table->String("reg_number")->nullable();
            $table->String("govt_id")->nullable();
            $table->String("business_license")->nullable();
            $table->String("bg_check_authorization")->nullable();
            $table->Text("address")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendors');
    }
};
