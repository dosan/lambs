<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCorralTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lambs', function (Blueprint $table) {
            $table->increments('id');
            $table->date('birth_date');
            $table->date('death_date');
            $table->tinyInteger('corral_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Schema::drop('corrals');
    }
}
