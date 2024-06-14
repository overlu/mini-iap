<?php
/**
 * This file is part of Mini Iap.
 * @auth lupeng
 */
declare(strict_types=1);

namespace MiniIap\Drivers\Google\DeveloperNotifications;

use MiniIap\Drivers\Google\DeveloperNotifications\Contracts\NotificationPayload;

/**
 * OneTimePurchaseNotification Class
 * One-time product notification
 * Note: A OneTimeProductNotification is sent only for some types of one-time purchases.
 * For more information, see Integrate the library into your app.
 * @link https://developer.android.com/google/play/billing/integrate
 * @link https://developer.android.com/google/play/billing/rtdn-reference#one-time
 */
class OneTimePurchaseNotification implements NotificationPayload
{
    public const ONE_TIME_PRODUCT_CANCELED = 2;
    public const ONE_TIME_PRODUCT_PURCHASED = 1;
    /**
     * @var string
     */
    protected string $version;

    /**
     * @var int
     */
    protected int $notificationType;

    /**
     * @var string
     */
    protected string $purchaseToken;

    /**
     * @var string
     */
    protected string $sku;

    /**
     * OneTimePurchaseNotification constructor.
     */
    public function __construct(string $version, int $notificationType, string $purchaseToken, string $sku)
    {
        $this->version = $version;
        $this->notificationType = $notificationType;
        $this->purchaseToken = $purchaseToken;
        $this->sku = $sku;
    }

    /**
     * @param array $attributes
     * @return OneTimePurchaseNotification
     */
    public static function create(array $attributes): OneTimePurchaseNotification
    {
        return new self(
            $attributes['version'],
            $attributes['notificationType'],
            $attributes['purchaseToken'],
            $attributes['sku']
        );
    }

    public function getVersion(): string
    {
        return $this->version;
    }

    public function getNotificationType(): int
    {
        return $this->notificationType;
    }

    public function getPurchaseToken(): string
    {
        return $this->purchaseToken;
    }

    public function getSku(): string
    {
        return $this->sku;
    }

    public function getType(): string
    {
        return self::ONE_TIME_PRODUCT_NOTIFICATION;
    }
}
