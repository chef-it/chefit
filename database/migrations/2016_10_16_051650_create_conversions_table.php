<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConversionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conversions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('master_list', false, true);
            $table->integer('left_quantity', false, true);
            $table->integer('left_unit', false, true);
            $table->integer('right_quantity', false, true);
            $table->integer('right_unit', false, true);
            $table->integer('owner', false, true);
            $table->timestamps();
            $table->foreign('master_list')
                ->references('id')->on('master_list')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('left_unit')
                ->references('id')->on('units')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('right_unit')
                ->references('id')->on('units')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('owner')
                ->references('id')->on('users')
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
        Schema::dropIfExists('conversions');
    }
}
