<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFotoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('foto', function (Blueprint $table) {
            $table->increments('id_foto');
            $table->string('archivo');
            $table->text('detalle');
            $table->boolean('estado')->default(true);
            $table->integer('id_seguimiento_foto');
            $table->foreign('id_seguimiento_foto')->references('id_seguimiento_foto')->on('seguimiento_fotografico');
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
        Schema::dropIfExists('foto');
    }
}
