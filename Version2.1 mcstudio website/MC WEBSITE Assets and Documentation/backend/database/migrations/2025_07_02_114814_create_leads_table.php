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
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('phone');
            $table->text('address')->nullable();
            $table->string('education');
            $table->string('experience');
            $table->string('current_role')->nullable();
            $table->string('company')->nullable();
            $table->text('languages')->nullable(); // store as JSON
            $table->text('cloud_platforms')->nullable(); // store as JSON
            $table->string('ai_experience');
            $table->string('availability');
            $table->text('motivation');
            $table->string('specialization');
            $table->text('additional_info')->nullable();
            $table->string('laptop_access');
            $table->string('internet_quality')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
