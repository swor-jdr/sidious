<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNamesToTransactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("transactions", function (Blueprint $table) {
            $table->string("from_name")->nullable();
            $table->string("to_name")->nullable();
        });

        Schema::table("accounts", function (Blueprint $table) {
            $table->string("owner_name")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("transactions", function (Blueprint $table) {
            $table->dropColumn('from_name');
            $table->dropColumn('to_name');
        });

        Schema::table("accounts", function (Blueprint $table) {
            $table->dropColumn("owner_name");
        });
    }
}
