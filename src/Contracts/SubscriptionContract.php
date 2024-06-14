<?php
/**
 * This file is part of Mini Iap.
 * @auth lupeng
 */
declare(strict_types=1);

namespace MiniIap\Contracts;

use MiniIap\Drivers\Apple\Receipts\ReceiptResponse;
use MiniIap\Drivers\Apple\ServerNotifications\V2DecodedPayload;
use MiniIap\Drivers\Google\Subscriptions\SubscriptionPurchase;
use MiniIap\ValueObjects\Time;

/**
 * Interface SubscriptionContract.
 */
interface SubscriptionContract
{
    public const PROVIDER_APP_STORE = 'app-store';
    public const PROVIDER_GOOGLE_PLAY = 'google-play';

    public function getExpiryTime(): Time;

    public function getItemId(): string;

    public function getProvider(): string;

    public function getUniqueIdentifier(): string;

    /**
     * @return mixed|SubscriptionPurchase|ReceiptResponse|V2DecodedPayload
     */
    public function getProviderRepresentation(): mixed;
}
