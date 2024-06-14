<?php
/**
 * This file is part of Mini Iap.
 * @auth lupeng
 */
declare(strict_types=1);

namespace MiniIap\Drivers\Apple\Receipts;

use MiniIap\Drivers\Apple\ValueObjects\LatestReceiptInfo;
use MiniIap\Drivers\Apple\ValueObjects\PendingRenewal;
use MiniIap\Drivers\Apple\ValueObjects\Receipt;
use MiniIap\Drivers\Apple\ValueObjects\Status;
use Mini\Contracts\Support\Arrayable;

/**
 * Class ReceiptResponse
 * @package App\Payment\Apple\Receipts
 * @see https://developer.apple.com/documentation/appstorereceipts/responsebody
 */
class ReceiptResponse implements Arrayable
{
    public const ENV_SANDBOX = 'Sandbox';

    public const ENV_PRODUCTION = 'Production';

    /**
     * 生成收据的环境
     * @var string|null
     */
    protected ?string $environment;

    /**
     * 指示请求过程中发生错误的指示符
     * @var bool|null
     */
    protected ?bool $isRetryable;

    /**
     * 最新的Base64编码的应用程序收据，仅针对包含自动续订订阅的收据返回
     * @var string|null
     */
    protected ?string $latestReceipt;

    /**
     * 包含所有应用内购买交易的数组
     * @var array|LatestReceiptInfo[]|null
     */
    protected ?array $latestReceiptInfo;

    /**
     * 在JSON文件中，一个数组，其中每个元素都包含挂起的续订信息
     * 对于product_id标识的每个自动可再生订阅
     * @var array|PendingRenewal[]|null
     */
    protected ?array $pendingRenewalInfo;

    /**
     * 发送用于验证的收据
     * @var array|null
     */
    protected ?array $receipt;

    /**
     * 如果收据有效，则为“0”；如果有错误，则为状态代码
     * @var int
     * @see https://developer.apple.com/documentation/appstorereceipts/status
     */
    protected int $status;

    /**
     * @var bool
     */
    private bool $parsedLatestReceiptInfo;

    /**
     * @var bool
     */
    private bool $parsedPendingRenewalInfo;

    /**
     * 响应的原始数据
     * @var array
     */
    private array $rawBody = [];

    /**
     * @deprecated Use ReceiptResponse::fromArray() instead.
     * Using it will result in inaccessibility to the response body as an array.
     */
    public function __construct(int $status)
    {
        $this->status = $status;
        $this->parsedLatestReceiptInfo = false;
        $this->parsedPendingRenewalInfo = false;
    }

    /**
     * Static factory method
     *
     * @param array $body
     *
     * @return ReceiptResponse
     */
    public static function fromArray(array $body): self
    {
        $obj = new self($body['status']);
        $obj->rawBody = $body;

        $obj->environment = $body['environment'] ?? null;
        $obj->isRetryable = $body['is-retryable'] ?? null;
        $obj->latestReceipt = $body['latest_receipt'] ?? null;
        $obj->latestReceiptInfo = $body['latest_receipt_info'] ?? null;
        $obj->pendingRenewalInfo = $body['pending_renewal_info'] ?? null;
        $obj->receipt = $body['receipt'] ?? null;

        return $obj;
    }

    /**
     * @return string|null
     */
    public function getEnvironment(): ?string
    {
        return $this->environment;
    }

    /**
     * @return bool|null
     */
    public function getIsRetryable(): ?bool
    {
        return $this->isRetryable;
    }

    /**
     * @return string|null
     */
    public function getLatestReceipt(): ?string
    {
        return $this->latestReceipt;
    }

    /**
     * @return array|LatestReceiptInfo[]|LatestReceiptInfo
     */
    public function getLatestReceiptInfo(bool $first = false): array
    {
        if (is_null($this->latestReceiptInfo)) {
            return [];
        }

        if ($this->parsedLatestReceiptInfo) {
            return $this->latestReceiptInfo;
        }

        $data = [];

        foreach ($this->latestReceiptInfo as $receiptInfo) {
            $data[] = LatestReceiptInfo::fromArray($receiptInfo);
        }

        $this->latestReceiptInfo = $data;
        $this->parsedLatestReceiptInfo = true;

        return $this->latestReceiptInfo;
    }


    /**
     * @param bool $first
     * @return array|PendingRenewal[]|PendingRenewal
     */
    public function getPendingRenewalInfo(bool $first = false): mixed
    {
        if (is_null($this->pendingRenewalInfo)) {
            return [];
        }

        if ($this->parsedPendingRenewalInfo) {
            return $this->pendingRenewalInfo;
        }

        $data = [];
        foreach ($this->pendingRenewalInfo as $renewalInfo) {
            $data[] = PendingRenewal::fromArray($renewalInfo);
        }

        $this->pendingRenewalInfo = $data;
        $this->parsedPendingRenewalInfo = true;

        return $first ? $this->pendingRenewalInfo[0] : $this->pendingRenewalInfo;
    }

    /**
     * @return Receipt|null
     */
    public function getReceipt(): ?Receipt
    {
        return is_array($this->receipt) ?
            Receipt::fromArray($this->receipt) :
            null;
    }

    /**
     * @return Status
     */
    public function getStatus(): Status
    {
        return new Status($this->status);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->rawBody;
    }
}
