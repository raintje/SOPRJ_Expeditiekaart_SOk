<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLayerItemsLayerItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('layer_items_layer_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('layer_item_id');
            $table->foreign('layer_item_id')->references('id')->on('layer_items')->onDelete('cascade');
            $table->unsignedBigInteger('linked_layer_item_id');
            $table->foreign('linked_layer_item_id')->references('id')->on('layer_items')->onDelete('cascade');
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
        Schema::dropIfExists('layer_items_layer_items');
    }
}
