<?php

use Illuminate\Database\Seeder;

class units_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('units')->insert([
            [
                'name' => 'oz',
                'system' => '1',
                'weight' => '1',
                'order' => '1',
                'factor' => '1',
            ],
            [
                'name' => 'fl oz',
                'system' => '1',
                'weight' => '0',
                'order' => '3',
                'factor' => '1',
            ],
            [
                'name' => 'gram',
                'system' => '3',
                'weight' => '1',
                'order' => '2',
                'factor' => '1',
            ],
            [
                'name' => 'ml',
                'system' => '3',
                'weight' => '0',
                'order' => '3',
                'factor' => '1',
            ],
            [
                'name' => 'cup',
                'system' => '1',
                'weight' => '0',
                'order' => '6',
                'factor' => '8',
            ],
            [
                'name' => 'pint',
                'system' => '1',
                'weight' => '0',
                'order' => '7',
                'factor' => '16',
            ],
            [
                'name' => 'qt',
                'system' => '1',
                'weight' => '0',
                'order' => '8',
                'factor' => '32',
            ],
            [
                'name' => 'half gallon',
                'system' => '1',
                'weight' => '0',
                'order' => '9',
                'factor' => '64',
            ],
            [
                'name' => 'gallon',
                'system' => '1',
                'weight' => '0',
                'order' => '10',
                'factor' => '128',
            ],
            [
                'name' => 'tsp',
                'system' => '1',
                'weight' => '0',
                'order' => '4',
                'factor' => '0.166667',
            ],
            [
                'name' => 'Tbsp',
                'system' => '1',
                'weight' => '0',
                'order' => '5',
                'factor' => '.5',
            ],
            [
                'name' => 'liter',
                'system' => '3',
                'weight' => '0',
                'order' => '4',
                'factor' => '1000',
            ],
            [
                'name' => 'Kg',
                'system' => '3',
                'weight' => '1',
                'order' => '1',
                'factor' => '1000',
            ],
            [
                'name' => 'lb',
                'system' => '1',
                'weight' => '1',
                'order' => '2',
                'factor' => '16',
            ],
            [
                'name' => 'ea',
                'system' => '2',
                'weight' => '2',
                'order' => '1',
                'factor' => '1',
            ],
            [
                'name' => 'portion',
                'system' => '2',
                'weight' => '2',
                'order' => '2',
                'factor' => '1',
            ]
        ]);
    }
}
