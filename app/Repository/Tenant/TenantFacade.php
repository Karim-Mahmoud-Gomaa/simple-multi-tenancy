<?php

namespace App\Repository\Tenant;
use \Illuminate\Support\Facades\Facade;
class TenantFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'App\Repository\Tenant\TenantService';
    }
}
