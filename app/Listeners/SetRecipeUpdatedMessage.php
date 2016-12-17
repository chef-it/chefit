<?php

namespace App\Listeners;

use App\Events\RecipeUpdated;
use App\Events\SendSuccessMessage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SetRecipeUpdatedMessage
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  RecipeUpdated  $event
     * @return void
     */
    public function handle(RecipeUpdated $event)
    {
        $recipeCostPercent = $event->recipe->cost_percent;
        if ($recipeCostPercent != $event->oldCostPercent) {
            $recipeName = $event->recipe->name;
            $message = 'Recipe "' . $recipeName . '" has updated. '.
                'Costing percentage has been changed from ' . $event->oldCostPercent . '% to '.
                $recipeCostPercent . '%';;
            event(new SendSuccessMessage($message));
        }
    }
}
