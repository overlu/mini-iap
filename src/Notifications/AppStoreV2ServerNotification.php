<?php
/**
 * This file is part of Mini Iap.
 * @auth lupeng
 */
declare(strict_types=1);

namespace MiniIap\Notifications;

use MiniIap\Contracts\HasSubtype;
use MiniIap\Contracts\ServerNotificationContract;
use MiniIap\Contracts\SubscriptionContract;
use MiniIap\Drivers\Apple\ServerNotifications\V2DecodedPayload;
use MiniIap\Subscriptions\AppleSubscription;

class AppStoreV2ServerNotification implements ServerNotificationContract, HasSubtype
{
    private V2DecodedPayload $payload;

    /**
     * Prevents the creation of the object from outside the class.
     */
    private function __construct(V2DecodedPayload $payload)
    {
        $this->payload = $payload;
    }

    /**
     * Static constructor.
     */
    public static function fromDecodedPayload(V2DecodedPayload $decodedPayload): self
    {
        return new self($decodedPayload);
    }

    public function getType(): string
    {
        return $this->payload->getType();
    }

    public function getSubscription(): SubscriptionContract
    {
        return AppleSubscription::fromV2DecodedPayload($this->payload);
    }

    public function isTest(): bool
    {
        return V2DecodedPayload::TYPE_TEST === $this->payload->getType();
    }

    public function getBundle(): string
    {
        return $this->payload->getAppMetadata()->bundleId();
    }

    /**
     * Gets the notification payload.
     */
    public function getPayload(): array
    {
        return $this->payload->toArray();
    }

    /**
     * Gets subscription subtype.
     */
    public function getSubtype(): string
    {
        return $this->payload->getSubType();
    }

    public function getProvider(): string
    {
        return self::PROVIDER_APP_STORE;
    }
}
