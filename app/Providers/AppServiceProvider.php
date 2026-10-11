<?php

namespace App\Providers;

use App\Http\Controllers\Api\Admin\OrderDriverController;
use App\Services\AssignDriver\AssignDriverService;
use App\Services\AssignDriver\LeastBusyDriverService;
use App\Services\AssignDriver\LongestIdleDriverService;
use App\Services\AssignDriver\Strategies\DriverSelectionInterface;
use App\Services\AssignDriver\Strategies\LeastBusyDriverStrategy;
use App\Services\AssignDriver\Strategies\LongestIdleDriverStrategy;
use App\Services\OrderDispatcherService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Model;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->when(LongestIdleDriverService::class)
                    ->needs(DriverSelectionInterface::class)
                    ->give(LongestIdleDriverStrategy::class);

        $this->app->when(LeastBusyDriverService::class)
                    ->needs(DriverSelectionInterface::class)
                    ->give(LeastBusyDriverStrategy::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::preventLazyLoading(! app()->isProduction());   
    }
}
