<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoiceRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_records', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('master_list_id', false, true);
            $table->decimal('price', 5, 2);
            $table->decimal('ap_quantity', 5, 2);
            $table->integer('ap_unit', false, true);
            $table->string('category')->nullable();
            $table->integer('invoice_id', false, true);
            $table->integer('user_id', false, true);
            $table->timestamps();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('invoice_id')
                ->references('id')->on('invoices')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('master_list_id')
                ->references('id')->on('master_list')
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
        Schema::dropIfExists('invoice_records');
    }
}
