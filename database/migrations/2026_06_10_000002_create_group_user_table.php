<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('group_user', function (Blueprint $table) {
            $table->id();
            // Using unsignedBigInteger handles custom fields flawlessly
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('study_group_id');
            $table->string('role')->default('member');
            $table->timestamps();

            // Foreign Key Links
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('study_group_id')->references('id')->on('study_groups')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('group_user');
    }
};
