<?php

namespace Step2Dev\LazySetting\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Orchestra\Testbench\TestCase as Orchestra;
use Step2Dev\LazySetting\LazySettingServiceProvider;

class TestCase extends Orchestra
{
    use RefreshDatabase;
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Step2Dev\\LazySetting\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            LazySettingServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app): void
    {
        config()->set('database.default', 'testing');
        config()->set('database.connections.testing.prefix', '');
        config()->set('lazy.setting.table', 'settings');
        config()->set('lazy-setting.default.type', 'string');

        $migration = include __DIR__.'/../database/migrations/create_lazy_setting_table.php.stub';
        $migration->up();

    }
}
