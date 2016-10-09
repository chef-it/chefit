<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecipesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('owner', false, true);
            $table->decimal('portions_per_batch', 10, 3);
            $table->decimal('menu_price', 10, 1)->nullable();
            $table->decimal('batch_quantity', 10, 6)->nullable();
            $table->integer('batch_unit', false, true)->nullable();
            $table->integer('component_only');
            $table->timestamps();
            $table->foreign('owner')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('batch_unit')
                ->references('id')->on('units')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recipes');
    }
}
