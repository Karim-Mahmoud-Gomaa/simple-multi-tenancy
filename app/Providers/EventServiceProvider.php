<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    public function register()
    {
        
        $this->app->bind('App\Repository\User\UserRepositoryInterface','App\Repository\User\UserRepository');
        $this->app->bind('App\Repository\Admin\AdminRepositoryInterface','App\Repository\Admin\AdminRepository');
        $this->app->bind('App\Repository\Product\ProductRepositoryInterface','App\Repository\Product\ProductRepository');
        $this->app->bind('App\Repository\Tenant\TenantRepositoryInterface','App\Repository\Tenant\TenantRepository');
		$this->app->bind('App\Repository\Property\PropertyRepositoryInterface','App\Repository\Property\PropertyRepository');
		$this->app->bind('App\Repository\ProductDetail\ProductDetailRepositoryInterface','App\Repository\ProductDetail\ProductDetailRepository');
    }

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
