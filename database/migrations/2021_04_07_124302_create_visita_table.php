<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVisitaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visita', function (Blueprint $table) {
            $table->increments('id_visita');
            $table->date('fecha_visita');
            $table->time('hora_visita');
            $table->integer('duracion_minutos');
            $table->datetime('fecha_programacion');
            $table->double('latitud', 8, 8)->nullable();
            $table->double('longitud', 8, 8)->nullable();
            $table->string('direccion')->nullable();
            $table->string('departamento')->nullable();
            $table->string('ciudad')->nullable();
            $table->string('provincia')->nullable();
            $table->string('localidad')->nullable();
            $table->integer('aprobado')->default(0);
            $table->boolean('estado')->default(false);
            $table->boolean('borrado')->default(false);
            $table->integer('id_credito');            
            $table->integer('id_users');
            $table->foreign('id_users')->references('id_users')->on('users');
            $table->foreign('id_credito')->references('id_credito')->on('credito');
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
        Schema::dropIfExists('visita');
    }
}
