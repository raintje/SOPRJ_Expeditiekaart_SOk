<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFirstLayerItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('first_layer_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('layer_item_id');
            $table->enum('categorie', ['familie/sociaal','bedrijfskunde','persoonlijke ontwikkeling']);//TODO define in one place
            $table->integer('x_pos')->nullable();
            $table->integer('y_pos')->nullable();
            $table->timestamps();
            $table->foreign('layer_item_id')->references('id')->on('layer_items');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('first_layer_items');
    }
}
