<?php
/**
 * This file is part of Mini Iap.
 * @auth lupeng
 */
declare(strict_types=1);

namespace MiniIap\Subscriptions;

use MiniIap\Contracts\SubscriptionContract;
use MiniIap\Drivers\Google\DeveloperNotifications\DeveloperNotification;
use MiniIap\Drivers\Google\DeveloperNotifications\SubscriptionNotification;
use MiniIap\Drivers\Google\Subscriptions\SubscriptionPurchase;
use MiniIap\Exceptions\InvalidNotificationTypeException;
use MiniIap\Facades\Subscription;
use MiniIap\ValueObjects\Time;

class GoogleSubscription implements SubscriptionContract
{
    protected SubscriptionPurchase $subscription;

    protected string $itemId;

    protected string $token;

    /**
     * GoogleSubscription constructor.
     */
    public function __construct(SubscriptionPurchase $subscription, string $itemId, string $token)
    {
        $this->subscription = $subscription;
        $this->itemId = $itemId;
        $this->token = $token;
    }


    public static function createFromDeveloperNotification(DeveloperNotification $rtdNotification,): self
    {
        $notification = $rtdNotification->getPayload();

        // Make sure the notification is a subscription notification
        if (!$notification instanceof SubscriptionNotification) {
            throw InvalidNotificationTypeException::create(SubscriptionNotification::class, get_class($notification));
        }

        $packageName = $rtdNotification->getPackageName();

        $subscriptionPurchase = Subscription::googlePlay()
            ->packageName($packageName)
            ->itemId($notification->getSubscriptionId())
            ->token($notification->getPurchaseToken())
            ->get();

        return new self(
            $subscriptionPurchase,
            $notification->getSubscriptionId(),
            $notification->getPurchaseToken()
        );
    }

    public function getExpiryTime(): Time
    {
        $time = $this->subscription->getExpiryTime();
        assert(!is_null($time));

        return Time::fromGoogleTime($time);
    }

    public function getItemId(): string
    {
        return $this->itemId;
    }

    public function getProvider(): string
    {
        return 'google_play';
    }

    public function getUniqueIdentifier(): string
    {
        return $this->token;
    }

    public function getProviderRepresentation(): SubscriptionPurchase
    {
        return $this->subscription;
    }
}
