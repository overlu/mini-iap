<?php
/**
 * This file is part of Mini Iap.
 * @auth lupeng
 */
declare(strict_types=1);

namespace MiniIap\Notifications;

use MiniIap\Contracts\ServerNotificationContract;
use MiniIap\Contracts\SubscriptionContract;
use MiniIap\Drivers\Google\DeveloperNotifications\DeveloperNotification;
use MiniIap\Subscriptions\GoogleSubscription;

/**
 * Class GoogleServerNotification.
 */
class GoogleServerNotification implements ServerNotificationContract
{
    public const TESTING_NOTIFICATION = -1;

    private DeveloperNotification $notification;

    /**
     * GoogleServerNotification constructor.
     */
    public function __construct(DeveloperNotification $notification)
    {
        $this->notification = $notification;
    }

    public function getType(): string
    {
        $type = $this->isTest() ?
            self::TESTING_NOTIFICATION :
            $this->notification->getPayload()->getNotificationType();

        return (string)$type;
    }

    public function getSubscription(): SubscriptionContract
    {
        return GoogleSubscription::createFromDeveloperNotification($this->notification);
    }

    public function isTest(): bool
    {
        return $this->notification->isTestNotification();
    }

    public function getBundle(): string
    {
        return $this->notification->getPackageName();
    }

    /**
     * Gets the notification payload.
     */
    public function getPayload(): array
    {
        return $this->notification->toArray();
    }

    public function getProvider(): string
    {
        return self::PROVIDER_GOOGLE_PLAY;
    }
}
