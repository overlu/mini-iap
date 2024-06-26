<?php
/**
 * This file is part of Mini Iap.
 * @auth lupeng
 */
declare(strict_types=1);

namespace MiniIap\Notifications;

use MiniIap\Contracts\ServerNotificationContract;
use MiniIap\Contracts\SubscriptionContract;
use MiniIap\Drivers\Apple\ServerNotifications\ServerNotification;
use MiniIap\Drivers\Apple\ValueObjects\LatestReceiptInfo;
use MiniIap\Subscriptions\AppStoreSubscription;
use MiniIap\ValueObjects\Time;

class AppStoreServerNotification implements ServerNotificationContract
{
    private ServerNotification $notification;

    /**
     * AppStoreServerNotification constructor.
     */
    public function __construct(ServerNotification $notification)
    {
        $this->notification = $notification;
    }

    public function getType(): string
    {
        return $this->notification->getNotificationType();
    }

    public function getSubscription(): SubscriptionContract
    {
        $firstReceipt = $this->getFirstReceipt();
        assert($firstReceipt instanceof LatestReceiptInfo);

        return new AppStoreSubscription($firstReceipt);
    }

    public function isTest(): bool
    {
        return false;
    }

    private function getFirstReceipt(): ?LatestReceiptInfo
    {
        $unifiedReceipt = $this->notification->getUnifiedReceipt();

        if ($unifiedReceipt && is_array($receipts = $unifiedReceipt->getLatestReceiptInfo()) && !empty($receipts)) {
            $latestReceiptInfo = $receipts[0];
            assert($latestReceiptInfo instanceof LatestReceiptInfo);

            return $latestReceiptInfo;
        }

        return null;
    }

    public function isAutoRenewal(): bool
    {
        return true === $this->notification->getAutoRenewStatus();
    }

    public function getAutoRenewStatusChangeDate(): ?Time
    {
        $time = $this->notification->getAutoRenewStatusChangeDate();
        if (!is_null($time)) {
            return Time::fromAppStoreTime($time);
        }

        return null;
    }

    public function getBundle(): string
    {
        return (string)$this->notification->getBid();
    }

    /**
     * Gets the notification payload.
     */
    public function getPayload(): array
    {
        return $this->notification->toArray();
    }

    public function getAutoRenewProductId(): ?string
    {
        return $this->notification->getAutoRenewProductId();
    }

    public function getProvider(): string
    {
        return self::PROVIDER_APP_STORE;
    }
}
