<?php

namespace App\Providers;

use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Date;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureCommands();
        $this->configureModels();
        $this->configureDates();
    }
    /**
     * Configure the app commands
     * @return void
     */
    private function configureCommands(): void
    {
        DB::prohibitDestructiveCommands(
            $this->app->isProduction(),
        ); // prohibit user from runnig DB destructive commands in production like "migrate:fresh"
    }
    /**
     * Configure the app models
     * @return void
     */
    private function configureModels(): void
    {
        Model::unguard();

        Model::shouldBeStrict();
    }
    /**
     * Configure the app Dates
     * @return void
     */
    private function configureDates(): void
    {
        Date::use(CarbonImmutable::class);
        // Make date objects immutable to prevent wierd behavior whene minepulating dates
    }
}
