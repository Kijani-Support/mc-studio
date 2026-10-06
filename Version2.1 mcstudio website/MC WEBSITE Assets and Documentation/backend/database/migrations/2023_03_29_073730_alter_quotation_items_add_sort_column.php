<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('quotation_items', function (Blueprint $table) {
            $table->unsignedInteger('sort')->default(0)->after('id');
        });
    }

    public function down()
    {
        Schema::table('quotation_items', function (Blueprint $table) {
            $table->dropColumn('sort');
        });
    }
};
