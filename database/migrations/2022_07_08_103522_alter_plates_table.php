<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plates', function (Blueprint $table) {
            $table->string('plate_type')->nullable();
            $table->string('product_type')->nullable();
            $table->string('client_code')->nullable();
            $table->index('production_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('plates', function (Blueprint $table) {
            $table->dropColumn('plate_type');
            $table->dropColumn('product_type');
            $table->dropColumn('client_code');
            $table->dropIndex(['production_id']);
        });
    }
};
