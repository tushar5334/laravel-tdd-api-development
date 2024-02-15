<?php

namespace App\Providers;

use Google\Client;
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
        $this->app->singleton(Client::class, function ($client) {
            $config = config('services.google');
            //$client = app(Client::class);
            $client = new Client();
            $client->setClientId($config['id']);
            $client->setClientSecret($config['secret']);
            $client->setRedirectUri($config['callback_url']);
            return $client;
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
