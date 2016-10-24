<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMasterList extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_list', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->decimal('price', 5, 2);
            $table->decimal('ap_quantity', 5, 2);
            $table->integer('ap_unit', false, true);
            $table->decimal('yield', 10, 6);
            $table->decimal('ap_small_price', 10, 6);
            $table->integer('owner', false, true);
            $table->timestamps();
            $table->foreign('ap_unit')
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
        Schema::dropIfExists('master_list');
    }
}
