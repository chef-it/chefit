<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\MasterListUpdated' => [
            'App\Listeners\SetMasterListUpdatedMessage',
            'App\Listeners\RecalculateRecipeEntry',
        ],
        'App\Events\RecipeUpdated' => [
            'App\Listeners\RecalculateRecipe',
            'App\Listeners\SetRecipeUpdatedMessage'
        ],
        'App\Events\SendSuccessMessage' => [
            'App\Listeners\SetSuccessMessage'
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
