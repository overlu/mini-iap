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
final class HandlerHelpers implements HandlerHelpersInterface
{
    private Request $request;
    private Validator $validator;
    private UrlGenerator $urlGenerator;
    private EventFactory $eventFactory;

    public function __construct(Request $request, Validator $validator, UrlGenerator $urlGenerator, EventFactory $eventFactory)
    {
        $this->request = $request;
        $this->validator = $validator;
        $this->urlGenerator = $urlGenerator;
        $this->eventFactory = $eventFactory;
    }

    public function getRequest(): Request
    {
        return $this->request;
    }

    public function getValidator(): Validator
    {
        return $this->validator;
    }

    public function getUrlGenerator(): UrlGenerator
    {
        return $this->urlGenerator;
    }

    public function getEventFactory(): EventFactory
    {
        return $this->eventFactory;
    }
}
