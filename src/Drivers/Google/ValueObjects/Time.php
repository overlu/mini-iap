<?php
/**
 * This file is part of Mini Iap.
 * @auth lupeng
 */
declare(strict_types=1);

namespace MiniIap\Drivers\Google\ValueObjects;

use Carbon\Carbon;
use DateTime;

final class Time
{
    /**
     * @var Carbon
     */
    private Carbon $carbon;

    /**
     * Time constructor.
     *
     * @param float|int|string $timestampMs
     */
    public function __construct(float|int|string $timestampMs)
    {
        $this->carbon = Carbon::createFromTimestampMs($timestampMs);
    }

    public function isFuture(): bool
    {
        return Carbon::now()->lessThan($this->carbon);
    }

    public function isPast(): bool
    {
        return Carbon::now()->greaterThan($this->carbon);
    }

    public function getCarbon(): Carbon
    {
        return $this->carbon;
    }

    public function toDateTime(): DateTime
    {
        return $this->carbon->toDateTime();
    }
}
