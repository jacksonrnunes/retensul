<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CriarTabelaMeliSuperCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('melisupercategories', function (Blueprint $table) {
            $table->increments('melisupercategories_id');
            $table->string('melisupercategories_id_original',15);
            $table->string('melisupercategories_descricao',80);
            $table->string('melisupercategories_url',255);
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
        Schema::drop('melisupercategories');
    }
}
