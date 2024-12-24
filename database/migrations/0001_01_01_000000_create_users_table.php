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
    $table->string('first_name', 50);
    $table->string('last_name', 50);
    $table->string('telephone', 10)->unique();
    $table->enum('user_type', ['end_user', 'admin']);
    $table->string('password');
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


