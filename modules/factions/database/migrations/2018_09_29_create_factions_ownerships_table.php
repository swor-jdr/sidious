<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FactionsOwnershipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_elements', function (Blueprint $table) {
            $table->unsignedMediumInteger("element_id");
            $table->string("element_type");
            $table->unsignedMediumInteger("group_id")->index();

            $table->boolean('isLeader')->default(false);
            $table->boolean('isMain')->default(false);
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('group_elements');
    }
}