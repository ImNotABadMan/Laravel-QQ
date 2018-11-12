<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class QqUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('qq_users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('nickname')->default('');
            $table->string('gender')->default('');
            $table->string('province')->default('');
            $table->string('city')->default('');
            $table->smallInteger('year')->default(0);
            $table->tinyInteger('is_yellow_vip')->default(0);
            $table->tinyInteger('vip')->default(0);
            $table->tinyInteger('yellow_vip_level')->default(0)->unsigned();
            $table->tinyInteger('level')->default(0);
            $table->tinyInteger('is_yellow_year_vip')->default(0);
        });
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
