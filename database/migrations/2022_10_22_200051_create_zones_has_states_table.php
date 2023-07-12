<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateZonesHasStatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('zones_has_states', function (Blueprint $table) {
            $table->integer('zones_id')->unsigned();
            $table->integer('states_id')->unsigned();
            
            $table->index('states_id', 'fk_zones_has_states_states1_idx');
            $table->index('zones_id', 'fk_zones_has_states_zones1_idx');

            $table->foreign('zones_id', 'fk_zones_has_states_zones1_idx')
            ->references('id')->on('zones');

            $table->foreign('states_id', 'fk_zones_has_states_states1_idx')
                ->references('id')->on('states');
            
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
        Schema::dropIfExists('zones_has_states');
    }
}
