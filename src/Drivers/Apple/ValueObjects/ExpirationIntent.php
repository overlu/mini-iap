<?php
/**
 * This file is part of Mini Iap.
 * @auth lupeng
 */
declare(strict_types=1);

namespace MiniIap\Drivers\Apple\ValueObjects;

use Stringable;

/**
 * Class ExpirationIntent
 * 订阅过期的原因
 * @see https://developer.apple.com/documentation/appstorereceipts/expiration_intent
 * @package App\Payment\Apple\ValueObjects
 */
final class ExpirationIntent implements Stringable
{
    public const VOLUNTARY_CANCEL = 1;
    public const BILLING_ERROR = 2;
    public const DID_NOT_AGREE_PRICE_INCREASE = 3;
    public const PRODUCT_UNAVAILABLE = 4;
    public const UNKNOWN_ERROR = 5;

    /**
     * @var int
     */
    private int $value;

    /**
     * ExpirationIntent constructor.
     * @param int $value
     */
    public function __construct(int $value)
    {
        $this->value = $value;
    }

    /**
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string)$this->getValue();
    }
}
