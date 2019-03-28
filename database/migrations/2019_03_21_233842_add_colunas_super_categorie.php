<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColunasSuperCategorie extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('melisupercategories', function (Blueprint $table) {
            $table->string('melisupercategories_picture', 255)
                    ->nullable()
                    ->after('melisupercategories_url');
            $table->string('melisupercategories_permalink', 255)
                    ->nullable()
                    ->after('melisupercategories_url');
            $table->integer('melisupercategories_total_items_in_this_category')
                    ->nullable()
                    ->after('melisupercategories_url');
            $table->string('melisupercategories_attribute_types', 100)
                    ->nullable()
                    ->after('melisupercategories_url');
            $table->string('melisupercategories_meta_categ_id', 255)
                    ->nullable()
                    ->after('melisupercategories_url');
            $table->string('melisupercategories_attributable', 255)
                    ->nullable()
                    ->after('melisupercategories_url');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('melisupercategories', function (Blueprint $table) {
            $table->dropColumn('melisupercategories_picture');
            $table->dropColumn('melisupercategories_permalink');
            $table->dropColumn('melisupercategories_total_items_in_this_category');
            $table->dropColumn('melisupercategories_attribute_types');
            $table->dropColumn('melisupercategories_meta_categ_id');
            $table->dropColumn('melisupercategories_attributable');
        });
    }
}
