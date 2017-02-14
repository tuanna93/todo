<?php

namespace App\Providers;

use App\Events\ItemCreated;
use App\Events\ItemDeleted;
use App\Events\ItemUpdated;
use Event;
use App\Item;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Item::created(function ($item) {
            Event::fire(new ItemCreated($item));
        });

        Item::updated(function ($item) {
            Event::fire(new ItemUpdated($item));
        });

        Item::deleted(function ($item) {
            Event::fire(new ItemDeleted($item));
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
