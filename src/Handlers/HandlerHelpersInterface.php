<?php
/**
 * This file is part of Mini Iap.
 * @auth lupeng
 */
declare(strict_types=1);

namespace MiniIap\Handlers;

use MiniIap\Events\EventFactory;
use Mini\Contracts\Request;
use Mini\Contracts\Routing\UrlGenerator;
use Mini\Contracts\Validator;

/**
 * Handler Helpers
 * This class is used to provide common services to the handlers.
 */
interface HandlerHelpersInterface
{
    public function getRequest(): Request;

    public function getValidator(): Validator;

    public function getUrlGenerator(): UrlGenerator;

    public function getEventFactory(): EventFactory;
}
