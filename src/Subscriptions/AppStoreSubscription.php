<?php
/**
 * This file is part of Mini Iap.
 * @auth lupeng
 */
declare(strict_types=1);

namespace MiniIap\Subscriptions;

use MiniIap\Contracts\SubscriptionContract;
use MiniIap\Drivers\Apple\ValueObjects\LatestReceiptInfo;
use MiniIap\ValueObjects\Time;

class AppStoreSubscription implements SubscriptionContract
{
    private LatestReceiptInfo $receipt;

    /**
     * AppStoreSubscription constructor.
     */
    public function __construct(LatestReceiptInfo $receipt)
    {
        $this->receipt = $receipt;
    }

    public function getExpiryTime(): Time
    {
        $expiryTime = $this->receipt->getExpiresDate();
        assert(!is_null($expiryTime));

        return Time::fromAppStoreTime($expiryTime);
    }

    public function getItemId(): string
    {
        return $this->receipt->getProductId();
    }

    public function getProvider(): string
    {
        return 'app-store';
    }

    public function getUniqueIdentifier(): string
    {
        return $this->receipt->getOriginalTransactionId();
    }

    public function getProviderRepresentation(): LatestReceiptInfo
    {
        return $this->receipt;
    }
}
