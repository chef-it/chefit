<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecipeElementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipe_elements', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('recipe', false, true);
            $table->integer('master_list', false, true);
            $table->integer('owner', false, true);
            $table->decimal('quantity', 10, 3);
            $table->integer('unit', false, true);
            $table->timestamps();
            $table->foreign('recipe')
                ->references('id')->on('recipes')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('master_list')
                ->references('id')->on('master_list')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('owner')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('unit')
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
        Schema::dropIfExists('recipe_elements');
    }
}
