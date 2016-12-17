<?php

namespace App\Listeners;

use App\Classes\Controller\RecipeElementHelper;
use App\Classes\Controller\RecipeHelper;
use App\Events\MasterListUpdated;
use App\Events\RecipeUpdated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class RecalculateRecipeEntry
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(RecipeElementHelper $elementHelper)
    {
        $this->elementHelper = $elementHelper;
    }

    /**
     * Handle the event.
     *
     * @param  MasterListUpdated  $event
     * @return void
     */
    public function handle(MasterListUpdated $event)
    {

        foreach ($event->masterlist->elements as $element) {
            $this->elementHelper->updateNumbers($element);
            event(new RecipeUpdated($element->recipe));
        }
    }
}
