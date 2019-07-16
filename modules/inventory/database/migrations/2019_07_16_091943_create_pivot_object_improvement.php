<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePivotObjectImprovement extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('improvement_object', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->unsignedMediumInteger("possession_id")->index();
            $table->unsignedMediumInteger("improvement_id")->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pivot_object_improvement');
    }
}
