<?php
/**
 * This file is part of Mini Iap.
 * @auth lupeng
 */
declare(strict_types=1);

namespace MiniIap\Http\Controllers;

use Exception;
use Mini\Contracts\Request;
use MiniIap\Handlers\HandlerFactory;

/**
 * Server notification controller.
 *
 * This controller handles the incoming requests by the IAP service providers
 * and dispatches relevant events.
 */
class ServerNotificationController
{
    /**
     * Handles the server notification request.
     * @throws Exception
     */
    public function handle(HandlerFactory $handlerFactory, Request $request): string
    {
        $handler = $handlerFactory->create();

        $handler->execute();

        return 'ok';
    }
}
