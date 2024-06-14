<?php
/**
 * This file is part of Mini Iap.
 * @auth lupeng
 */
declare(strict_types=1);

namespace MiniIap\Handlers;

use MiniIap\Contracts\NotificationHandlerContract;
use Mini\Contracts\Container\BindingResolutionException;
use Mini\Contracts\Foundation\Application;
use Mini\Contracts\Request;
use RuntimeException;

/**
 * Handler factory.
 * Creates a notification handler instance based on the provider type
 */
class HandlerFactory
{
    protected Application $application;

    protected Request $request;

    public function __construct(Application $application, Request $request)
    {
        $this->application = $application;
        $this->request = $request;
    }

    /**
     * @return NotificationHandlerContract
     * @throws BindingResolutionException
     */
    public function create(): NotificationHandlerContract
    {
        $provider = (string)$this->request->get('provider');

        if ('app-store' === $provider && $this->request->has('signedPayload')) {
            $provider = 'app-store-v2';
        }

        return match ($provider) {
            'google-play' => $this->application->make(GooglePlayNotificationHandler::class),
            'app-store' => $this->application->make(AppStoreNotificationHandler::class),
            'app-store-v2' => $this->application->make(AppStoreV2NotificationHandler::class),
            default => throw new RuntimeException(sprintf('Invalid provider: {%s}', $provider)),
        };
    }
}
