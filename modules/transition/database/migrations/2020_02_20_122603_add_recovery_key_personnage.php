<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRecoveryKeyPersonnage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("personnages", function (Blueprint $table) {
            $table->string("recover_key")->nullable();
            $table->unsignedMediumInteger("v4_id")->unique()->nullable();
            $table->string("v4_email")->nullable();
            $table->string("timezone")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("personnages", function (Blueprint $table) {
            $table->dropColumn("recover_key");
            $table->dropColumn("v4_id");
            $table->dropColumn("v4_email");
            $table->dropColumn("timezone");
        });
    }
}
