<?php
/**
 * This file is part of Mini Iap.
 * @auth lupeng
 */
declare(strict_types=1);

namespace MiniIap\Contracts;

/**
 * Interface ServerNotificationContract.
 */
interface ServerNotificationContract
{
    public const PROVIDER_GOOGLE_PLAY = 'google-play';
    public const PROVIDER_APP_STORE = 'app-store';

    /**
     * Gets the notification type.
     */
    public function getType(): string;

    /**
     * Gets the subscription associated with the notification.
     */
    public function getSubscription(): SubscriptionContract;

    /**
     * Returns true if the notification is a test notification.
     */
    public function isTest(): bool;

    /**
     * Gets the application bundle.
     */
    public function getBundle(): string;

    /**
     * Gets the notification payload.
     */
    public function getPayload(): array;

    /**
     * Gets the notification provider.
     */
    public function getProvider(): string;
}
