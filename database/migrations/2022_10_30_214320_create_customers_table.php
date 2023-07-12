<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('identification', 100)->unique();
            $table->string('name', 100);
            $table->string('address', 100);
            $table->string('phone', 100);
            $table->integer('users_id')->unsigned();
            $table->integer('states_id')->unsigned();
            $table->integer('zones_id')->unsigned();
            $table->integer('categories_id')->unsigned();
            $table->integer('status_id')->unsigned(); 

            $table->index('users_id','fk_customers_users_idx');
            $table->index('states_id','fk_customers_states1_idx');
            $table->index('zones_id', 'fk_customers_zones1_idx');
            $table->index('categories_id', 'fk_customers_categories1_idx');
            $table->index('status_id', 'fk_customers_status1_idx');


            $table->foreign('users_id')
		        ->references('id')->on('users');
                
            $table->foreign('states_id')
                ->references('id')->on('states');
                
            $table->foreign('zones_id')
		        ->references('id')->on('zones');
                
            $table->foreign('categories_id')
                ->references('id')->on('categories');

            $table->foreign('status_id')
                ->references('id')->on('status');

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
        Schema::dropIfExists('customers');
    }
}
