<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeguimientoFotograficoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seguimiento_fotografico', function (Blueprint $table) {
            $table->increments('id_seguimiento_foto');
            $table->text('descripcion');
            $table->double('latitud', 8, 8)->nullable();
            $table->double('longitud', 8, 8)->nullable();
            $table->integer('id_visita')->nullable();
            $table->integer('id_credito');
            $table->foreign('id_visita')->references('id_visita')->on('visita');
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
        Schema::dropIfExists('seguimiento_fotografico');
    }
}
