<?php
/**
 * This file is part of Mini Iap.
 * @auth lupeng
 */
declare(strict_types=1);

namespace MiniIap\Drivers\Apple\ValueObjects;

/**
 * Class Cancellation
 * 取消类表示响应主体接收信息中的两个独立信息部分，即取消时间和原因。时间和原因被接收在两个单独的密钥中，但它们在逻辑上是相关的，或者耦合。
 * @see https://developer.apple.com/documentation/appstorereceipts/responsebody/latest_receipt_info
 */
final class Cancellation
{
    public const REASON_APP_ISSUE = 1;

    public const REASON_OTHER = 0;

    /**
     * 应用商店退还交易或将其从家庭共享中撤销的时间。
     * @var Time
     */
    private Time $time;

    /**
     * 退款或撤销交易的原因。
     * “1”表示客户由于您的应用程序中的实际或感知问题而取消了交易。
     * “0”表示该交易因其他原因被取消；例如，如果客户意外购买。
     * @var int
     */
    private int $reason;

    /**
     * @param Time $time
     * @param int $reason
     */
    public function __construct(Time $time, int $reason)
    {
        $this->time = $time;
        $this->reason = $reason;
    }

    /**
     * @return Time
     */
    public function getTime(): Time
    {
        return $this->time;
    }

    /**
     * @return int
     */
    public function getReason(): int
    {
        return $this->reason;
    }

    /**
     * @deprecated
     * @return bool
     */
    public function isDueAppIssue(): bool
    {
        return $this->reason === self::REASON_APP_ISSUE;
    }

    /**
     * @deprecated
     * @return bool
     */
    public function isDueAnotherReason(): bool
    {
        return $this->reason === self::REASON_OTHER;
    }
}
