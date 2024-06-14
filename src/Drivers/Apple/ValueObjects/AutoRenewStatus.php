<?php
/**
 * This file is part of Mini Iap.
 * @auth lupeng
 */
declare(strict_types=1);

namespace MiniIap\Drivers\Apple\ValueObjects;

use Stringable;

/**
 * Class AutoRenewStatus
 * @package App\Payment\Apple\ValueObjects
 * 自动续订的续订状态。
 * @see https://developer.apple.com/documentation/appstorereceipts/auto_renew_status?changes=latest_minor
 */
final class AutoRenewStatus implements Stringable
{
    public const WILL_RENEW = 1;
    public const TURNED_OFF = 0;

    /**
     * @var int
     */
    private int $value;

    /**
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
    public function __toString(): string
    {
        return (string)$this->getValue();
    }
}
