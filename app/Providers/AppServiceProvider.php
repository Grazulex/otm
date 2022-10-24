<?php

namespace App\Providers;

use Filament\Facades\Filament;
use Filament\Navigation\NavigationGroup;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Model::shouldBeStrict(!$this->app->environment('production'));

        Filament::serving(function () {
            Filament::registerNavigationGroups([
                NavigationGroup::make()
                    ->label('Cash ledgers')
                    ->icon('heroicon-s-cash'),
                NavigationGroup::make()
                    ->label('Plates')
                    ->icon('heroicon-s-shopping-cart'),
                NavigationGroup::make()
                    ->label('Customers')
                    ->icon('heroicon-s-users')
                    ->collapsed(false),
                NavigationGroup::make()
                    ->label('Admin')
                    ->icon('heroicon-s-cog')
                    ->collapsed(false),
            ]);
        });
    }
}
