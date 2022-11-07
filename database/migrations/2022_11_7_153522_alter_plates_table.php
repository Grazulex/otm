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
        Schema::table('plates', function (Blueprint $table) {
            $table->string('return_reason')->nullable();
            $table->tinyInteger('is_damaged')->default(0);
            $table->foreignId('back_id')->nullable()->constrained('backs')->onDelete('cascade');
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
            $table->dropColumn('return_reason_id');
            $table->dropColumn('is_damaged');
            $table->dropColumn('back_id');
        });
    }
};
