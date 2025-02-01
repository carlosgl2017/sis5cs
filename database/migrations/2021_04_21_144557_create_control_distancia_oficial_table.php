<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;



class CreateControlDistanciaOficialTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('control_distancia_oficial', function (Blueprint $table) {
            $table->increments('id_control_distancia');
            $table->double('latitud');
            $table->double('longitud');
            $table->integer('id_control');
            $table->foreign('id_control')->references('id_control')->on('control_oficial');
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
        Schema::dropIfExists('control_distancia_oficial');
    }
}
