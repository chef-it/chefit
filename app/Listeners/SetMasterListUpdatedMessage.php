<?php

namespace App\Listeners;

use App\Events\MasterListUpdated;
use App\Events\SendSuccessMessage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SetMasterListUpdatedMessage
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
     * @param  MasterListUpdated  $event
     * @return void
     */
    public function handle(MasterListUpdated $event)
    {
        $name = $event->masterlist->name;
        $message = $name . ' Updated.';
        event(new SendSuccessMessage($message));
    }
}
