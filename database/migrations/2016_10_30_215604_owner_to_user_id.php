<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OwnerToUserId extends Migration
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
            $table->renameColumn('owner', 'user_id');
        });


        Schema::table('master_list', function($table)
        {
            $table->renameColumn('owner', 'user_id');
        });

        Schema::table('master_list_price_trackings', function($table)
        {
            $table->renameColumn('owner', 'user_id');
        });

        Schema::table('recipe_elements', function($table)
        {
            $table->renameColumn('owner', 'user_id');
        });

        Schema::table('recipes', function($table)
        {
            $table->renameColumn('owner', 'user_id');
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
            $table->renameColumn('user_id', 'owner');
        });


        Schema::table('master_list', function($table)
        {
            $table->renameColumn('user_id', 'owner');
        });

        Schema::table('master_list_price_trackings', function($table)
        {
            $table->renameColumn('user_id', 'owner');
        });

        Schema::table('recipe_elements', function($table)
        {
            $table->renameColumn('user_id', 'owner');
        });

        Schema::table('recipes', function($table)
        {
            $table->renameColumn('user_id', 'owner');
        });
    }
}
