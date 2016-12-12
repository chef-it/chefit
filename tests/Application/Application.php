php<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;

/** Quick and garbage test until real ones are written */
class Application extends TestCase
{
    /** @test */
    public function run_through_pages()
    {
        $this->actingAs(User::find(8));

        $ingredient = factory(App\MasterList::class)->make();

        $this->visit('masterlist')
            ->see('Master List')
            ->click('Add New Item')
            ->seePageIs('masterlist/create')
            ->type($ingredient->name, 'name')
            ->type($ingredient->price, 'price')
            ->type($ingredient->yield, 'yield')
            ->type($ingredient->ap_quantity, 'ap_quantity')
            ->select($ingredient->ap_unit, 'ap_unit') //lb
            //->type('Test Vendor', 'vendor')
            //->type('Test Category', 'category')
            ->press('Add')
            ->seePageIs('masterlist')
            ->see($ingredient->name);

        $this->click('Conversion')
            ->see($ingredient->name . ' Conversion')
            ->type('1', 'left_quantity')
            ->type('1', 'right_quantity')
            ->select(2, 'right_unit')
            ->press('Update')
            ->click('back');

        $this->click('Statistics')
            ->see($ingredient->name)
            ->see($ingredient->price)
            ->see($ingredient->ap_quantity);

        $this->visit('masterlist')
            ->click('Edit')
            ->type($ingredient->price + 1, 'price')
            ->press('Update')
            ->visit('masterlist')
            ->see($ingredient->price + 1)
            ->press('Delete')
            ->dontSee($ingredient->name);
    }
}
