<?php
/**
 * This file is part of Mini Iap.
 * @auth lupeng
 */
declare(strict_types=1);

namespace MiniIap\Handlers;

use MiniIap\Drivers\Apple\ServerNotifications\V2DecodedPayload;
use MiniIap\Notifications\AppStoreV2ServerNotification;
use Mini\Facades\Logger;

/**
 * Class AppStoreV2NotificationHandler
 * This class is used to handle AppStore V2 notifications.
 */
class AppStoreV2NotificationHandler extends AbstractNotificationHandler
{
    protected JwsServiceInterface $jwsService;

    public function __construct(HandlerHelpersInterface $helpers, JwsServiceInterface $jwsService)
    {
        $this->jwsService = $jwsService;

        parent::__construct($helpers);
    }

    /**
     * @return void
     */
    protected function handle()
    {
        $decodedPayload = V2DecodedPayload::fromJws($this->jwsService->parse());
        $serverNotification = AppStoreV2ServerNotification::fromDecodedPayload($decodedPayload);

        if ($serverNotification->isTest()) {
            $signedPayload = (string)$this->request->get('signedPayload');
            Logger::info(
                'AppStoreV2NotificationHandler: Test notification received ' .
                $signedPayload
            );

            return;
        }

        $event = $this->eventFactory->create($serverNotification);
        event($event);
    }

    protected function isAuthorized(): bool
    {
        return $this->jwsService->verify();
    }

    /**
     * @return string[][]
     */
    protected function rules(): array
    {
        return [
            'signedPayload' => ['required', 'string'],
        ];
    }
}
