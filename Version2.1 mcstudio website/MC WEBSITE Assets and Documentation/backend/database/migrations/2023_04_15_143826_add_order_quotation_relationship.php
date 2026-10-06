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
        // Add quotation_id to orders table
        Schema::table('orders', function($table){
            $table->foreignId('quotation_id')->nullable()->constrained()->cascadeOnUpdate()->nullOnDelete();
        });

        // Add order_id to quotations table
        Schema::table('quotations', function($table){
            $table->foreignId('order_id')->nullable()->constrained()->cascadeOnUpdate()->nullOnDelete();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function($table){
            $table->dropForeign('orders_quotation_id_foreign');
        });        
        
        
        Schema::table('quotations', function($table){
            $table->dropForeign('quotations_orders_id_foreign');
        });
    }
};
