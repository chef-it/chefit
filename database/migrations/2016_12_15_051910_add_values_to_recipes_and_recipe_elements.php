<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddValuesToRecipesAndRecipeElements extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('recipes', function (Blueprint $table) {
            $table->decimal('cost', 10, 6)->unsigned()->after('batch_unit');
            $table->decimal('cost_percent', 10, 4)->unsigned()->after('cost');
            $table->decimal('portion_price', 10, 6)->unsigned()->after('cost_percent');
        });


        Schema::table('recipe_elements', function(Blueprint $table)
        {
            $table->decimal('cost', 10, 6)->unsigned()->after('unit_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('recipes', function (Blueprint $table) {
            $table->dropColumn('cost');
            $table->dropColumn('cost_percent');
            $table->dropColumn('portion_price');
        });

        Schema::table('recipe_elements', function(Blueprint $table)
        {
            $table->dropColumn('cost');
        });
    }
}
