<?php
/**
 * This file is part of Mini Iap.
 * @auth lupeng
 */
declare(strict_types=1);

namespace MiniIap\Handlers;

use MiniIap\Drivers\Apple\ServerNotifications\ServerNotification;
use MiniIap\Notifications\AppStoreServerNotification;
use Mini\Facades\Logger;

/**
 * App Store server notification handler.
 *
 * Handles notifications sent by App store.
 * Dispatches the App store subscription event related to the notification type.
 */
class AppStoreNotificationHandler extends AbstractNotificationHandler
{
    /**
     * @return void
     */
    protected function handle():void
    {
        $attributes = $this->request->all();
        $serverNotification = ServerNotification::fromArray($attributes);
        $appStoreNotification = new AppStoreServerNotification($serverNotification);

        if ($appStoreNotification->isTest()) {
            Logger::info('AppStore Test Notification');
        }

        $event = $this->eventFactory->create($appStoreNotification);
        event($event);
    }

    /**
     * @return string[][]
     */
    protected function rules(): array
    {
        return [
            'unified_receipt' => ['array', 'required'],
            'unified_receipt.latest_receipt' => ['required'],
            'unified_receipt.latest_receipt_info' => ['required', 'array'],
            'notification_type' => ['required'],
        ];
    }
}
