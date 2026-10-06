<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('project_tasks', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('sort')->default(0);
            $table->foreignId('user_id');
            $table->foreignId('project_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('status',20)->default(0);
            $table->string('priority',20)->default(0);
            $table->string('title',250);
            $table->text('content');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('project_tasks');
    }
};
