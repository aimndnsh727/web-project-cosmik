<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations to build study groups table schema.
     */
    public function up(): void
    {
        Schema::create('study_groups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('leader_id')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->string('subj_code');
            $table->text('description');
            $table->string('venue');
            $table->date('session_date');
            $table->time('session_time');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('study_groups');
    }
};