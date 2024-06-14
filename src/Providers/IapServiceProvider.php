<?php
/**
 * This file is part of Mini Iap.
 * @auth lupeng
 */
declare(strict_types=1);

namespace MiniIap\Providers;

use MiniIap\Contracts\EventFactory as EventFactoryContract;
use MiniIap\Drivers\Apple\Jws\AppStoreJwsVerifier;
use MiniIap\Drivers\Apple\Jws\JwsParser;
use MiniIap\Drivers\Apple\Jws\JwsVerifier;
use MiniIap\Drivers\Apple\Jws\Parser;
use MiniIap\Events\EventFactory;
use MiniIap\Handlers\HandlerHelpers;
use MiniIap\Handlers\HandlerHelpersInterface;
use MiniIap\Handlers\JwsService;
use MiniIap\Handlers\JwsServiceInterface;
use MiniIap\Http\Controllers\ServerNotificationController;
use MiniIap\Product;
use MiniIap\Subscription;
use Lcobucci\JWT\Decoder;
use Lcobucci\JWT\Encoding\JoseEncoder;
use Mini\Contracts\Container\BindingResolutionException;
use Mini\Service\AbstractServiceProvider;

class IapServiceProvider extends AbstractServiceProvider
{
    public const CONFIG_PATH = __DIR__ . '/../../config/iap.php';

    /**
     * @return void
     * @throws BindingResolutionException
     */
    public function register(): void
    {
        $this->registerConfig();

        $this->registerEvents();

        $this->bindFacades();

        $this->bindConcretes();
    }

    /**
     * @return void
     * @throws BindingResolutionException
     */
    private function registerConfig(): void
    {
        $this->mergeConfigFrom(self::CONFIG_PATH, 'iap');

        $googleApplicationCredentials = (string)config('iap.google-play.application_credentials');

        if (!empty($googleApplicationCredentials) && file_exists($googleApplicationCredentials)) {
            env(['GOOGLE_APPLICATION_CREDENTIALS' => $googleApplicationCredentials]);
        }
    }

    /**
     * Registers IAP event service provider.
     */
    private function registerEvents(): void
    {
        $dispatch = $this->app['events'];
        $events = (array)config('iap.events', []);
        foreach ($events as $event => $listen) {
            $dispatch->listen($event, $listen);
        }
    }

    /**
     * Binds facades.
     */
    private function bindFacades(): void
    {
        $this->app->singleton('iap.product', function () {
            return new Product();
        });

        $this->app->singleton('iap.subscription', function () {
            return new Subscription();
        });
    }

    /**
     * Bind concrete classes.
     */
    private function bindConcretes(): void
    {
        // Bind JWS
        $this->app->bind(JwsParser::class, Parser::class);
        $this->app->bind(JwsVerifier::class, AppStoreJwsVerifier::class);
        $this->app->bind(Decoder::class, JoseEncoder::class);

        // Bind Handlers
        $this->app->bind(EventFactoryContract::class, EventFactory::class);
        $this->app->bind(HandlerHelpersInterface::class, HandlerHelpers::class);
        $this->app->bind(JwsServiceInterface::class, JwsService::class);
    }

    public function boot(): void
    {
        $this->publishConfig();

        $this->bootRoutes();
    }

    /**
     * publishes configurations.
     */
    public function publishConfig(): void
    {
        if (RUN_ENV === 'artisan') {
            $paths = [self::CONFIG_PATH => config_path('iap.php')];
            $this->publishes($paths, 'config');
        }
    }

    /**
     * Boots routes.
     */
    public function bootRoutes(): void
    {
        $this->app['route']->registerHttpRoute(['ANY', '/iap/notifications', ServerNotificationController::class . '@handle']);
    }
}