<?php

namespace App\Components\RSS\Events;

use App\Components\DashboardEvent;

class FileContentFetched extends DashboardEvent
{
    /** @var array */
    public $items;

    public function __construct(array $items)
    {
        $this->items = $items;
    }
}
