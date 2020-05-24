<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddValidationToEconomyLines extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('economy_lines', function (Blueprint $table) {
            $table->boolean("isValidated")->default(false);
            $table->unsignedBigInteger("validatedBy")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('economy_lines', function (Blueprint $table) {
            $table->dropColumn(['isValidated', 'validatedBy']);
        });
    }
}
