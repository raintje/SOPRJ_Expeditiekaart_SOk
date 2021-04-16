<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropCategoryFromFirstLayerItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('first_layer_items', function (Blueprint $table) {
            $table->dropColumn('categorie');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('first_layer_items', function (Blueprint $table) {
            $table->enum('categorie', ['familie/sociaal','bedrijfskunde','persoonlijke ontwikkeling']);
        });
    }
}
