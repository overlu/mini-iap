<?php
/**
 * This file is part of Mini Iap.
 * @auth lupeng
 */
declare(strict_types=1);

namespace MiniIap\Handlers;

use MiniIap\Events\EventFactory;
use MiniIap\Contracts\NotificationHandlerContract;
use Mini\Contracts\Request;
use Mini\Contracts\Routing\UrlGenerator;
use Mini\Contracts\Validator;

abstract class AbstractNotificationHandler implements NotificationHandlerContract
{
    protected Request $request;
    protected Validator $validator;
    protected UrlGenerator $urlGenerator;
    protected EventFactory $eventFactory;

    public function __construct(HandlerHelpersInterface $helpers)
    {
        $this->request = $helpers->getRequest();
        $this->validator = $helpers->getValidator();
        $this->urlGenerator = $helpers->getUrlGenerator();
        $this->eventFactory = $helpers->getEventFactory();
    }

    /**
     * @return void
     */
    public function execute(): void
    {
        $this->validate();

        $this->handle();
    }

    protected function validate(): void
    {
        $this->validator->make($this->request->all(), $this->rules())->validate();
    }

    /**
     * @return string[][]
     */
    protected function rules(): array
    {
        return [];
    }

    abstract protected function handle();
}
