<?php
/**
 * This file is part of Mini Iap.
 * @auth lupeng
 */
declare(strict_types=1);

namespace MiniIap\Drivers\Google\DeveloperNotifications\Factories;

use MiniIap\Drivers\Google\DeveloperNotifications\Contracts\NotificationPayload;
use MiniIap\Drivers\Google\DeveloperNotifications\OneTimePurchaseNotification;
use MiniIap\Drivers\Google\DeveloperNotifications\SubscriptionNotification;
use MiniIap\Drivers\Google\DeveloperNotifications\TestNotification;

/**
 * Class NotificationPayloadFactory
 * @package MiniIap\Drivers\Google\DeveloperNotifications\Factories
 */
class NotificationPayloadFactory
{
    /**
     * @param array $data
     * @return NotificationPayload
     */
    public static function create(array $data): NotificationPayload
    {
        if (isset($data[NotificationPayload::ONE_TIME_PRODUCT_NOTIFICATION])) {
            return OneTimePurchaseNotification::create($data[NotificationPayload::ONE_TIME_PRODUCT_NOTIFICATION]);
        }

        if (isset($data[NotificationPayload::SUBSCRIPTION_NOTIFICATION])) {
            return SubscriptionNotification::create($data[NotificationPayload::SUBSCRIPTION_NOTIFICATION]);
        }

        return new TestNotification($data['version']);
    }
}
