<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMasterListPriceTrackingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_list_price_trackings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('master_list', false, true);
            $table->integer('owner', false, true);
            $table->decimal('price', 5, 2);
            $table->decimal('ap_quantity', 5, 2);
            $table->integer('ap_unit', false, true);
            $table->string('vendor')->nullable();
            $table->timestamps();
            $table->foreign('master_list')
                ->references('id')->on('master_list')
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
        Schema::dropIfExists('master_list_price_trackings');
    }
}
