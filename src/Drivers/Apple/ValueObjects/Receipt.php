<?php
/**
 * This file is part of Mini Iap.
 * @auth lupeng
 */
declare(strict_types=1);

namespace MiniIap\Drivers\Apple\ValueObjects;

/**
 * Class Receipt
 * 此类表示随请求一起发送到App Store的编码收据数据的解码版本。
 * @link https://developer.apple.com/documentation/appstorereceipts/responsebody/receipt
 * @package App\Payment\Apple\ValueObjects
 */
final class Receipt
{
    public const RECEIPT_TYPE_PRODUCTION = 'Production';
    public const RECEIPT_TYPE_PRODUCTION_VPP = 'ProductionVPP';
    public const RECEIPT_TYPE_SANDBOX = 'ProductionSandbox';
    public const RECEIPT_TYPE_PRODUCTION_VPP_SANDBOX = 'ProductionVPPSandbox';

    /**
     * @var string|null
     * @see Receipt::$appItemId
     */
    private ?string $adamId;

    /**
     * 最初，这是一个64位长的整数，所以，让我们把它看作是一个安全的字符串。由App Store Connect生成，并由App Store用于唯一识别购买的应用程序。
     * 应用程序仅在生产中分配此标识符。
     * @var string|null
     */
    private ?string $appItemId;

    /**
     * 应用程序的版本号。在沙盒中，该值始终为“1.0”。
     * @var string|null
     */
    private ?string $applicationVersion;

    /**
     * 收据所属应用程序的捆绑包标识符。
     * @var string|null
     */
    private ?string $bundleId;

    /**
     * 应用程序下载事务的唯一标识符。
     * @var int|null
     */
    private ?int $downloadId;

    /**
     * 通过批量购买计划购买的应用程序的收据到期时间
     * @var int|null
     */
    private ?int $expirationDate;

    /**
     * 一个数组，包含所有应用内购买交易的应用内购买收据字段。
     * @var array|null
     */
    private ?array $inApp;

    /**
     * 用户最初购买的应用程序的版本。
     * @var string|null
     */
    private ?string $originalApplicationVersion;

    /**
     * 购买原始应用程序的时间
     * @var int|null
     */
    private ?int $originalPurchaseDate;

    /**
     * 用户订购可用于预购的应用程序的时间。
     * @var int|null
     */
    private ?int $preOrderDate;

    /**
     * 应用商店生成收据的时间
     * @var int|null
     */
    private ?int $receiptCreationDate;

    /**
     * 生成的收据类型。该值对应于购买应用程序或VPP的环境
     * @var string|null
     */
    private ?string $receiptType;

    /**
     * 处理对verifyReceipt端点的请求并生成响应的时间
     * @var int|null
     */
    private ?int $requestDate;

    /**
     * 标识应用程序修订版的任意数字。在沙盒中，此键的值为“0”
     * @var int|null
     */
    private ?int $versionExternalIdentifier;

    /**
     * @var bool
     */
    private bool $inAppParsed;

    public function __construct()
    {
        $this->inAppParsed = false;
    }

    /**
     * @param array $attributes
     * @return static
     */
    public static function fromArray(array $attributes): self
    {
        $obj = new self();
        $obj->adamId = $attributes['adam_id'] ?? null;
        $obj->appItemId = $attributes['app_item_id'] ?? null;
        $obj->applicationVersion = $attributes['application_version'] ?? null;
        $obj->bundleId = $attributes['bundle_id'] ?? null;
        $obj->downloadId = $attributes['download_id'] ?? null;
        $obj->inApp = $attributes['in_app'] ?? null;
        $obj->originalPurchaseDate = $attributes['original_purchase_date_ms'] ?? null;
        $obj->receiptCreationDate = $attributes['receipt_creation_date_ms'] ?? null;
        $obj->receiptType = $attributes['receipt_type'] ?? null;
        $obj->requestDate = $attributes['request_date_ms'] ?? null;
        $obj->versionExternalIdentifier = $attributes['version_external_identifier'] ?? null;
        $obj->originalApplicationVersion = $attributes['original_application_version'] ?? null;
        $obj->expirationDate = $attributes['expiration_date_ms'] ?? null;
        $obj->preOrderDate = $attributes['preorder_date_ms'] ?? null;

        return $obj;
    }

    /**
     * @return string|null
     */
    public function getAdamId(): ?string
    {
        return $this->adamId;
    }

    /**
     * @return string|null
     */
    public function getAppItemId(): ?string
    {
        return $this->appItemId;
    }

    /**
     * @return string|null
     */
    public function getApplicationVersion(): ?string
    {
        return $this->applicationVersion;
    }

    /**
     * @return string|null
     */
    public function getBundleId(): ?string
    {
        return $this->bundleId;
    }

    /**
     * @return int|null
     */
    public function getDownloadId(): ?int
    {
        return $this->downloadId;
    }

    /**
     * @return Time|null
     */
    public function getExpirationDate(): ?Time
    {
        return
            $this->expirationDate ?
                new Time($this->expirationDate) :
                null;
    }

    /**
     * @return array|LatestReceiptInfo[]|null
     */
    public function getInApp(): ?array
    {
        if (is_null($this->inApp) || $this->inAppParsed) {
            return $this->inApp;
        }

        $data = [];
        foreach ($this->inApp as $receiptData) {
            $data[] = LatestReceiptInfo::fromArray($receiptData);
        }

        $this->inAppParsed = true;
        $this->inApp = $data;

        return $this->inApp;
    }

    /**
     * @return string|null
     */
    public function getOriginalApplicationVersion(): ?string
    {
        return $this->originalApplicationVersion;
    }

    /**
     * @return Time|null
     */
    public function getOriginalPurchaseDate(): ?Time
    {
        return
            $this->originalPurchaseDate ?
                new Time($this->originalPurchaseDate) :
                null;
    }

    /**
     * @return Time|null
     */
    public function getPreOrderDate(): ?Time
    {
        return
            $this->preOrderDate ?
                new Time($this->preOrderDate) :
                null;
    }

    /**
     * @return Time|null
     */
    public function getReceiptCreationDate(): ?Time
    {
        return
            $this->receiptCreationDate ?
                new Time($this->receiptCreationDate) :
                null;
    }

    /**
     * @return string|null
     */
    public function getReceiptType(): ?string
    {
        return $this->receiptType;
    }

    /**
     * @return Time|null
     */
    public function getRequestDate(): ?Time
    {
        return
            $this->requestDate ?
                new Time($this->requestDate) :
                null;
    }

    /**
     * @return int|null
     */
    public function getVersionExternalIdentifier(): ?int
    {
        return $this->versionExternalIdentifier;
    }
}
