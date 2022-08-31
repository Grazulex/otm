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
        Schema::table('customers', function (Blueprint $table) {
            $table->boolean('is_delivery_grouped')->default(false)->change();
            $table->boolean('is_delivery_bpost')->default(false)->change();
            $table->boolean('is_inmotiv_customer')->default(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->boolean('is_delivery_grouped')->default(true)->change();
            $table->boolean('is_delivery_bpost')->default(true)->change();
            $table->boolean('is_inmotiv_customer')->default(true)->change();
        });
    }
};
