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

            $table->string('name');

            $table->string('email')->unique();

            $table->string('password');

            $table->enum('role', ['admin', 'owner', 'tenant']);

            $table->string('avatar')->nullable();

            $table->string('phone')->nullable();

            $table->decimal('reputation_score', 2, 1)->default(5.0);

            $table->integer('total_reviews')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};