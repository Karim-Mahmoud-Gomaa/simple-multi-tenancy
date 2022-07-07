<?php

namespace App\Repository\User;
use \Illuminate\Support\Facades\Facade;
class UserFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'App\Repository\User\UserService';
    }
}