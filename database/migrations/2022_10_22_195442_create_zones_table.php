<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateZonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('zones', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->integer('users_id')->unsigned();
            $table->integer('seller_users_id')->unsigned();

            $table->index('users_id', 'fk_zones_users_idx');
            $table->index('seller_users_id', 'fk_zones_seller_users_idx');

            $table->foreign('users_id')
                ->references('id')->on('users');

            $table->foreign('seller_users_id')
                ->references('id')->on('users');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('zones');
    }
}
