<?php

namespace App\Components\Trello\Events;

use App\Components\DashboardEvent;

class FileContentFetched extends DashboardEvent
{
    /** @var string */
    public $fileContent;

    public function __construct(string $fileContent)
    {
        $this->fileContent = $fileContent;
    }
}
