<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddConfigEconomicCycle extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Inani\LaravelNovaConfiguration\Helpers\Configuration::set("LAST_ECONOMIC_CYCLE", \Carbon\Carbon::createFromFormat("m Y", \Carbon\Carbon::now()->subMonth()));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
