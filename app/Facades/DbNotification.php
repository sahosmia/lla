<?php
namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class DbNotification extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'db-notification';
    }
}