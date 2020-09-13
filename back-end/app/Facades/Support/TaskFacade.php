<?php

namespace App\Facades\Support;

use Illuminate\Support\Facades\Facade;

class TaskFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'task';
    }
}
