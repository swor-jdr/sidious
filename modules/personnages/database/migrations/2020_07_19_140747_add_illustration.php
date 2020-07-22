<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIllustration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("personnages", function (Blueprint $table) {
           $table->string("banner_url")->default("/assets/img/sw/default-banner.jpg");
           $table->string("avatar_tiny")->default("/assets/img/default-avatar.png");
           $table->string("avatar_regular")->default("/assets/img/default-avatar.png");
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
            $table->dropColumn("banner_url");
            $table->dropColumn("avatar_tiny");
            $table->dropColumn("avatar_regular");
        });
    }
}
