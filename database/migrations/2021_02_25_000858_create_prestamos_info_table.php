<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrestamosInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prestamos_info', function (Blueprint $table) {
            $table->integer('nroprestamo');
            $table->integer('nrosocio');
            $table->string('dnombre');
            $table->string('dci');
            $table->string('destadocivil');
            $table->string('ddireccion');
            $table->integer('existec')->nullable();
            $table->string('cnombre')->nullable();
            $table->string('cci')->nullable();
            $table->string('cestadocivil')->nullable();
            $table->string('cdireccion')->nullable();            
            $table->string('moneda')->nullable(); 
            $table->double('montoprestamo_sus')->nullable();          
            $table->double('montoprestamo_bs')->nullable();
            $table->string('ncuotasoriginal')->nullable();            
            $table->string('periodicidadpago')->nullable();            
            $table->string('estado')->nullable();
            $table->date('fechacontrato')->nullable();
            $table->integer('nnotaria')->nullable();
            $table->string('nombreaboga')->nullable();
            $table->integer('mesesampliacion')->nullable();
            $table->integer('cuotasadicionales')->nullable();
            $table->integer('namortizaciones')->nullable();
            $table->double('montodiferido')->nullable();
            $table->string('mesiniciopago')->nullable();
            $table->string('usuariocreated')->nullable();
            $table->string('usuariomodified')->nullable();
            $table->integer('nrocodeudores')->nullable();
            $table->primary('nroprestamo');
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
        Schema::dropIfExists('prestamos_info');
    }
}
