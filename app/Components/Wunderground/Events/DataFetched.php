<?php
/**
 * Created by Bas Hepping <info@mamoru.nl>.
 * Date: 14-6-2017
 * Time: 21:19
 */

namespace App\Components\Wunderground\Events;


use App\Components\DashboardEvent;

class DataFetched extends DashboardEvent
{
    public $wunderground;
    
    public function __construct($wunderground)
    {
        $this->wunderground = $wunderground;
    }
}