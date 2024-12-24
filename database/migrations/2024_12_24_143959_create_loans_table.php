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
        Schema::create('loans', function (Blueprint $table) {
             $table->id();
             $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
             $table->integer('amount');
             $table->integer('monthly_income');
             $table->enum('status', ['pending', 'approved', 'declined']);
             $table->timestamps();
        });
       

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
