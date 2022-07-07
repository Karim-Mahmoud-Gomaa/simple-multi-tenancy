<?php

namespace App\Repository\Admin;
use \Illuminate\Support\Facades\Facade;
class AdminFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'App\Repository\Admin\AdminService';
    }
}