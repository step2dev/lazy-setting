<?php

namespace Step2Dev\LazySetting;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Step2Dev\LazySetting\Commands\LazySettingCommand;
use Step2Dev\LazySetting\Services\SettingService;

class LazySettingServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('lazy-setting')
            ->hasConfigFile('lazy/setting')
            ->hasViews()
            ->hasMigration('create_lazy-setting_table')
            ->hasCommand(LazySettingCommand::class);
    }

    public function registeringPackage(): void
    {
        $this->app->singleton('setting', fn () => new SettingService());
    }
}
