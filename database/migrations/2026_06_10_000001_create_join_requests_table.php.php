<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('join_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('study_group_id');
            $table->string('status')->default('pending');
            $table->text('message')->nullable();
            $table->timestamps();

            // Foreign Key Links
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('study_group_id')->references('id')->on('study_groups')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('join_requests');
    }
};
