<?php

namespace App\Listeners;

use App\Events\SendSuccessMessage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SetSuccessMessage
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
     * @param  SendSuccessMessage  $event
     * @return void
     */
    public function handle(SendSuccessMessage $event)
    {
        $messages = session()->get('success_messages') ? : [];
        array_push($messages, $event->message);

        session()->flash(
            'success_messages',
            $messages
        );
    }
}
