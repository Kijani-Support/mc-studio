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
        Schema::table('payments', function (Blueprint $table) {
            $table->string('phone',30)->nullable()->constrained()->nullOnDelete();
            $table->string('name',200)->nullable()->constrained()->nullOnDelete();
            $table->string('number',50)->nullable()->constrained()->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn('phone');
            $table->dropColumn('name');
            $table->dropColumn('number');
        });
    }
};
