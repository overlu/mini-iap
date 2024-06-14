<?php
/**
 * This file is part of Mini Iap.
 * @auth lupeng
 */
declare(strict_types=1);

namespace MiniIap\Drivers\Google\ValueObjects;

/**
 * Cancellation.
 * Cancellation object contains data about the cancellation, including:
 * - cancel reason
 * - user cancellation time
 * - cancel survey result
 */
final class Cancellation
{
    public const CANCEL_REASON_BY_USER = 0;
    public const CANCEL_REASON_BY_SYSTEM = 1;
    public const CANCEL_REASON_REPLACED = 2;
    public const CANCEL_REASON_BY_DEVELOPER = 3;

    public const ATTR_CANCEL_REASON = 'cancelReason';
    public const ATTR_USER_CANCELLATION_TIME_MILLIS = 'userCancellationTimeMillis';
    public const ATTR_cancelSurveyResult = 'cancelSurveyResult';

    /**
     * The reason why a subscription was canceled or is not auto-renewing.
     *
     * @var int|null
     */
    private ?int $cancelReason = null;

    /**
     * @var string|null
     */
    private ?string $userCancellationTime = null;

    /**
     * @var array|null
     */
    private ?array $cancelSurveyResult = null;

    /**
     * @param int|null $cancelReason
     * @param string|null $userCancellationTime
     * @param array|null $cancelSurveyResult
     */
    public function __construct(?int $cancelReason, ?string $userCancellationTime, ?array $cancelSurveyResult)
    {
        $this->cancelReason = $cancelReason;
        $this->userCancellationTime = $userCancellationTime;
        $this->cancelSurveyResult = $cancelSurveyResult;
    }

    /**
     * @param array $attributes
     * @return static
     */
    public static function fromArray(array $attributes = []): self
    {
        $cancelReason = $attributes[self::ATTR_CANCEL_REASON] ?? null;
        $userCancellationTimeMillis = $attributes[self::ATTR_USER_CANCELLATION_TIME_MILLIS] ?? null;
        $cancelSurveyResult = $attributes[self::ATTR_cancelSurveyResult] ?? null;

        return new self($cancelReason, $userCancellationTimeMillis, $cancelSurveyResult);
    }

    public function isCancelled(): bool
    {
        return !is_null($this->cancelReason);
    }

    public function getCancelReason(): ?int
    {
        return $this->cancelReason;
    }

    public function getUserCancellationTime(): ?Time
    {
        return is_null($this->userCancellationTime)
            ? null
            : new Time($this->userCancellationTime);
    }

    public function getCancelSurveyResult(): ?SubscriptionCancelSurveyResult
    {
        return is_null($this->cancelSurveyResult)
            ? null
            : SubscriptionCancelSurveyResult::fromArray($this->cancelSurveyResult);
    }
}
