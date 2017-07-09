<?php
/**
 * Created by Bas Hepping <info@mamoru.nl>.
 * Date: 13-4-2017
 * Time: 20:25
 */

namespace App\Components\Nest\Events;


use App\Components\DashboardEvent;

class ReadNest extends DashboardEvent
{
    public $data;
    
    public function __construct()
    {
        $this->data = array_values(json_decode(file_get_contents(storage_path() . '/app/nest_session_info'), true))[0];
    }
}