<?php
/**
 * This file is part of Mini Iap.
 * @auth lupeng
 */
declare(strict_types=1);

namespace MiniIap\Drivers\Apple\ValueObjects;

use Carbon\Carbon;
use DateTime;
use Stringable;

/**
 * Class Time
 * @package App\Payment\Apple\ValueObjects
 */
final class Time implements Stringable
{
    /**
     * 自Unix纪元以来的微秒数。
     * @var int
     * @psalm-immutable
     */
    private int $timestampMilliseconds;

    /**
     * Time constructor
     * @param int $timestampMilliseconds
     */
    public function __construct(int $timestampMilliseconds)
    {
        $this->timestampMilliseconds = $timestampMilliseconds;
    }

    /**
     * @param Carbon $carbon
     *
     * @return static
     */
    public static function fromCarbon(Carbon $carbon): self
    {
        return new self($carbon->getTimestampMs());
    }

    /**
     * @param DateTime $dateTime
     *
     * @return static
     */
    public static function fromDateTime(DateTime $dateTime): self
    {
        return self::fromCarbon(Carbon::instance($dateTime));
    }

    /**
     * @return bool
     */
    public function isFuture(): bool
    {
        return $this->toCarbon()->isFuture();
    }

    /**
     * @return bool
     */
    public function isPast(): bool
    {
        return $this->toCarbon()->isPast();
    }

    /**
     * @return Carbon
     * @deprecated Use toCarbon() instead.
     */
    public function getCarbon(): Carbon
    {
        return $this->toCarbon();
    }

    /**
     * Converts the value object to a Carbon instance.
     *
     * @return Carbon
     */
    public function toCarbon(): Carbon
    {
        return Carbon::createFromTimestampMs($this->timestampMilliseconds);
    }

    /**
     * Convert the value object to a DateTime instance.
     *
     * @return DateTime
     */
    public function toDateTime(): DateTime
    {
        return $this->toCarbon()->toDateTime();
    }

    /**
     * @return string
     */
    public function toDateTimeString(): string
    {
        return $this->toCarbon()->toDateTimeString();
    }

    /**
     * @return DateTime
     */
    public function toDate(): DateTime
    {
        return $this->toCarbon()->toDate();
    }

    /**
     * @return string
     */
    public function toDateString(): string
    {
        return $this->toCarbon()->toDateString();
    }

    /**
     * @return string
     */
    public function toNextDateString(): string
    {
        return $this->toCarbon()->addDay()->toDateString();
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return (string)$this->toCarbon();
    }

    /**
     * 检查是否等于给定时间
     * @param Time $time
     * @return bool
     * @return string
     */
    public function equals(Time $time): bool
    {
        return $this->toCarbon()->eq($time->toCarbon());
    }
}
