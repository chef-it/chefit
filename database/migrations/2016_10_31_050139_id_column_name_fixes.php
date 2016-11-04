<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class IdColumnNameFixes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('conversions', function($table)
        {
            $table->renameColumn('master_list', 'master_list_id');
        });

        Schema::table('master_list_price_trackings', function($table)
        {
            $table->renameColumn('master_list', 'master_list_id');
        });

        Schema::table('recipe_elements', function($table)
        {
            $table->renameColumn('master_list', 'master_list_id');
        });

        Schema::table('recipe_elements', function($table)
        {
            $table->renameColumn('recipe', 'recipe_id');
        });

        Schema::table('recipe_elements', function($table)
        {
            $table->renameColumn('unit', 'unit_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('conversions', function($table)
        {
            $table->renameColumn('master_list_id', 'master_list');
        });

        Schema::table('master_list_price_trackings', function($table)
        {
            $table->renameColumn('master_list_id', 'master_list');
        });

        Schema::table('recipe_elements', function($table)
        {
            $table->renameColumn('master_list_id', 'master_list');
        });

        Schema::table('recipe_elements', function($table)
        {
            $table->renameColumn('recipe_id', 'recipe');
        });

        Schema::table('recipe_elements', function($table)
        {
            $table->renameColumn('unit_id', 'unit');
        });
    }
}
