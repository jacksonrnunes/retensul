<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CriarTabelaMelicategoriessettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('melicategories_settings', function (Blueprint $table) {
            $table->increments('melicategories_settings_id');
            $table->integer('melicategories_id')->unsigned();
            $table->foreign('melicategories_settings_id')->references('usuario')->on('melicategories_id');
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
        Schema::drop('melicategories_settings');
    }
}
