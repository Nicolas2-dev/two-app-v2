<?php

use Two\Support\Facades\Schema;
use Two\Database\Schema\Blueprint;
use Two\Database\Migrations\Migration;


class CreateOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('options', function (Blueprint $table)
        {
            $table->increments('id');
            $table->string('namespace', 100)->nullable();
            $table->string('group', 100);
            $table->string('item', 255)->nullable();
            $table->text('value')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('options');
    }

}
