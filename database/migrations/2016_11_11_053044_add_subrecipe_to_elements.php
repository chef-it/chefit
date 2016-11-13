<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSubrecipeToElements extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('recipe_elements', function(Blueprint $table)
        {
            $table->integer('master_list_id', false, true)->nullable()->change();
            $table->integer('sub_recipe_id', false, true)->nullable()->after('master_list_id');
            $table->string('type')->after('id')->default('masterlist');
            $table->foreign('sub_recipe_id')
                ->references('id')->on('recipes')
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
        Schema::table('recipe_elements', function(Blueprint $table)
        {
            $table->dropForeign(['sub_recipe_id']);
            $table->integer('master_list_id', false, true)->change();
            $table->dropColumn('sub_recipe_id')->nullable();
            $table->dropColumn('type');
        });
    }
}
