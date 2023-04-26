<?php

declare(strict_types=1);

namespace BombenProdukt\TaxCalculator;

use BombenProdukt\PackagePowerPack\Package\AbstractServiceProvider;

final class ServiceProvider extends AbstractServiceProvider
{
    public function packageRegistered(): void
    {
        $this->app->singleton('tax-calculator', function ($app) {
            $config = $app->config['laravel-tax-calculator'];

            return new Calculator($config['currency'], $config['locale'], $config['tax_rate']);
        });
    }

    public function provides()
    {
        return ['tax-calculator'];
    }
}
