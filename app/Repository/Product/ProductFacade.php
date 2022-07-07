<?php

namespace App\Repository\Product;
use \Illuminate\Support\Facades\Facade;
class ProductFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'App\Repository\Product\ProductService';
    }
}
