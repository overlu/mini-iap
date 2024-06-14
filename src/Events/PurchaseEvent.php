<?php
/**
 * This file is part of Mini Iap.
 * @auth lupeng
 */
declare(strict_types=1);

namespace MiniIap\Events;

use MiniIap\Contracts\PurchaseEventContract;
use MiniIap\Contracts\ServerNotificationContract;
use MiniIap\Contracts\SubscriptionContract;
use Mini\Events\Dispatchable;

abstract class PurchaseEvent implements PurchaseEventContract
{
    use Dispatchable;

    protected ServerNotificationContract $serverNotification;

    /**
     * SubscriptionPurchased constructor.
     */
    public function __construct(ServerNotificationContract $serverNotification)
    {
        $this->serverNotification = $serverNotification;
    }

    public function getServerNotification(): ServerNotificationContract
    {
        return $this->serverNotification;
    }

    public function getSubscription(): SubscriptionContract
    {
        return $this->serverNotification->getSubscription();
    }

    public function getSubscriptionId(): string
    {
        return $this->getSubscription()->getItemId();
    }

    public function getSubscriptionIdentifier(): string
    {
        return $this->getSubscription()->getUniqueIdentifier();
    }
}
