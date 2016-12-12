<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLineQuantityToInvoiceRecord extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoice_records', function (Blueprint $table) {
            $table->decimal('line_quantity', 5, 2)->after('master_list_id')->defualt('1');
            $table->decimal('total_price', 8, 2)->after('line_quantity');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoice_records', function (Blueprint $table) {
            $table->dropColumn('line_quantity');
            $table->dropColumn('total_price');
        });
    }
}
