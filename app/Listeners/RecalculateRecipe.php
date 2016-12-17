<?php

namespace App\Listeners;

use App\Classes\Controller\RecipeHelper;
use App\Events\RecipeUpdated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class RecalculateRecipe
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(RecipeHelper $recipeHelper)
    {
        $this->recipeHelper = $recipeHelper;
    }

    /**
     * Handle the event.
     *
     * @param  RecipeUpdated  $event
     * @return void
     */
    public function handle(RecipeUpdated $event)
    {
        $event->oldCostPercent = $event->recipe->cost_percent;
        $this->recipeHelper->updateNumbers($event->recipe);
        $pause = 1;
    }
}
