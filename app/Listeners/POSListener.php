<?php

namespace App\Listeners;

use App\Events\POS;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class POSListener
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
     * @param  POS  $event
     * @return void
     */
    public function handle(POS $event)
    {
        //
    }
}
