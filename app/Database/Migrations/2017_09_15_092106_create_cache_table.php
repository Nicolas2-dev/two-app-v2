<?php
/**
 * Two - CreateCacheTable
 *
 * @author  Nicolas Devoy
 * @email   nicolas@nicodev.fr 
 * @version 1.0.0
 * @date    15 Fevrier 2023
 */

use Two\Support\Facades\Schema;
use Two\Database\Schema\Blueprint;
use Two\Database\Migrations\Migration;


class CreateCacheTable extends Migration
{

    /**
     * Exécutez les migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cache', function (Blueprint $table)
        {
            $table->string('key')->unique();
            $table->text('value');
            $table->integer('expiration');
        });
    }

    /**
     * Inversez les migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cache');
    }

}
