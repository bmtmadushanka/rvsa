<?php

namespace App\Providers;

use App\Services\AcceptPaymentsService;
use App\Services\GetCompanyDetailsService;
use App\Services\SendSMSService;
use App\Services\ShowDifferenceService;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
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
        Schema::defaultStringLength(191);

        Blade::directive('ifFrontEnd', function() {
            return '<?php if (!$isBackEnd) { ?>';
        });
        Blade::directive('endIfFrontEnd', function() {
            return '<?php } ?>';
        });
        Blade::directive('ifBackEnd', function() {
            return '<?php if ($isBackEnd) { ?>';
        });
        Blade::directive('notBackEnd', function() {
            return '<?php } else { ?>';
        });
        Blade::directive('endIfBackEnd', function() {
            return '<?php } ?>';
        });

        $this->app->singleton('Company', function() {
            return new GetCompanyDetailsService();
        });
        $this->app->singleton('SMS', function() {
            return new SendSMSService();
        });
        $this->app->singleton('IPG', function() {
            return new AcceptPaymentsService();
        });
        $this->app->singleton('Diff', function() {
            return new ShowDifferenceService();
        });
    }
}
