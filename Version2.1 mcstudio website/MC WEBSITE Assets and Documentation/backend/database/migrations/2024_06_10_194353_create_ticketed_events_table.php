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
        Schema::create('ticketed_events', function (Blueprint $table) {
            $table->id();
            $table->string('event_name');
            $table->longText('event_description')->nullable();
            $table->string('event_location')->nullable();
            $table->date('event_startdate')->nullable();
            $table->date('event_enddate')->nullable();
            $table->float('price')->default(0);
            $table->integer('qty')->nullable();
            $table->string('category')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticketed_events');
    }
};
