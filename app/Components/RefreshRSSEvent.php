<?php

namespace App\Components;

use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class RefreshRSSEvent implements ShouldBroadcast
{
    /**
     * Get the channels the event should broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return ['rss-dashboard'];
    }
}
