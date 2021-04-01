<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCascadeOnDeleteToLayerItemsForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('first_layer_items', function (Blueprint $table) {
            $table->dropForeign(['layer_item_id']);
            $table->foreign('layer_item_id')->references('id')->on('layer_items')->onDelete('cascade');
        });

        Schema::table('files', function (Blueprint $table) {
            $table->dropForeign(['layer_item_id']);
            $table->foreign('layer_item_id')->references('id')->on('layer_items')->onDelete('cascade');
        });

        Schema::table('layer_items_layer_items', function (Blueprint $table) {
            $table->dropForeign(['layer_item_id']);
            $table->foreign('layer_item_id')->references('id')->on('layer_items')->onDelete('cascade');
            $table->dropForeign(['linked_layer_item_id']);
            $table->foreign('linked_layer_item_id')->references('id')->on('layer_items')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('_layer_items_foreign_keys', function (Blueprint $table) {
            //
        });
    }
}
