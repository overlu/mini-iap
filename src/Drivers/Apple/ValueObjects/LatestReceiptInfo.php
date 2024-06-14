<?php
/**
 * This file is part of Mini Iap.
 * @auth lupeng
 */
declare(strict_types=1);

namespace MiniIap\Drivers\Apple\ValueObjects;

use JsonSerializable;
use Mini\Contracts\Support\Arrayable;

/**
 * Class LatestReceiptInfo
 * LatestReceiptInfo类，包含应用内购买交易
 * @link https://developer.apple.com/documentation/appstorereceipts/responsebody/latest_receipt_info
 * @package App\Payment\Apple\ValueObjects
 */
final class LatestReceiptInfo implements Arrayable, JsonSerializable
{
    public const ENVIRONMENT_SANDBOX = 'Sandbox';
    public const ENVIRONMENT_PRODUCTION = 'Production';

    /**
     * 交易属于从服务中受益的家庭成员
     * @const string
     */
    public const OWNERSHIP_TYPE_FAMILY_SHARED = 'FAMILY_SHARED';

    /**
     * 交易属于买方
     * @const string
     */
    public const OWNERSHIP_TYPE_PURCHASED = 'PURCHASED';

    /**
     * 取消原因-应用程序问题
     * @const string
     */
    public const CANCELLATION_REASON_APP_ISSUE = '1';

    /**
     * 取消原因-其他
     * @const string
     */
    public const CANCELLATION_REASON_OTHER = '0';

    /**
     * @const string
     */
    private const TRUE = 'true';

    /**
     * 将事务与您自己服务上的用户关联的UUID，只有当您的应用程序提供了appAccountToken时，此字段才会出现(_:)
     * 当用户进行购买时；它只存在于沙箱环境中。
     * @see https://developer.apple.com/documentation/storekit/transaction/3749684-appaccounttoken?changes=latest_minor
     * @see https://developer.apple.com/documentation/storekit/product/purchaseoption/3749440-appaccounttoken?changes=latest_minor
     * @var string|null
     */
    private ?string $appAccountToken;

    /**
     * @var int|null
     */
    private ?int $cancellationDate;

    /**
     * @var int|null
     */
    private ?int $cancellationReason;

    /**
     * 订阅到期时间或续订时间，UNIX epoch时间格式，以毫秒为单位
     * @var int|null
     */
    private ?int $expiresDate;

    /**
     * 用户与他们可以访问的家庭共享购买的关系
     * @var string|null
     * @see https://developer.apple.com/documentation/appstorereceipts/in_app_ownership_type?changes=latest_minor
     */
    private ?string $inAppOwnershipType;

    /**
     * 表示自动可再生能源订阅是否处于入门价格期的指标
     * @var string|null
     * @see https://developer.apple.com/documentation/appstorereceipts/is_in_intro_offer_period?changes=latest_minor
     */
    private ?string $isInIntroOfferPeriod;

    /**
     * 自动续订是否处于免费试用期的指标
     * @see https://developer.apple.com/documentation/appstorereceipts/is_trial_period?changes=latest_minor
     * @var string|null
     */
    private ?string $isTrialPeriod;

    /**
     * 指示订阅由于升级而被取消的指示符，此字段仅适用于升级事务。
     *
     * @var bool|string|null
     */
    private $isUpgraded;

    /**
     * 客户兑换的订阅优惠代码的优惠参考名称。
     * @see https://developer.apple.com/documentation/appstorereceipts/offer_code_ref_name?changes=latest_minor
     * @var string|null
     */
    private ?string $offerCodeRefName;

    /**
     * 购买原始应用程序的时间，采用UNIX epoch时间格式，以毫秒为单位。
     * @var int|null
     */
    private ?int $originalPurchaseDate;

    /**
     * 原始购买的交易标识符。
     * @see https://developer.apple.com/documentation/appstorereceipts/original_transaction_id?changes=latest_minor
     * @var string
     */
    private string $originalTransactionId;

    /**
     * 购买产品的唯一标识符。
     * @var string
     */
    private string $productId;

    /**
     * 用户兑换的订阅优惠的标识符。
     * @see https://developer.apple.com/documentation/appstorereceipts/promotional_offer_id?changes=latest_minor
     * @var string|null
     */
    private ?string $promotionalOfferId;

    /**
     * 应用商店向用户帐户收取购买或恢复产品费用的时间
     * @var int|null
     */
    private ?int $purchaseDate;

    /**
     * 购买的消耗品数量。
     * @var int
     */
    private int $quantity;

    /**
     * 订阅所属的订阅组的标识符。
     * @see https://developer.apple.com/documentation/storekit/skproduct/2981047-subscriptiongroupidentifier?changes=latest_minor
     * @var string|null
     */
    private ?string $subscriptionGroupIdentifier;

    /**
     * 跨设备购买事件（包括订阅续订事件）的唯一标识符，此值是用于识别订阅购买的主键。
     *
     * @var string|null
     */
    private ?string $webOrderLineItemId;

    /**
     * 交易的唯一标识符，如购买、恢复或续订。
     * @see https://developer.apple.com/documentation/appstorereceipts/transaction_id?changes=latest_minor
     * @var string
     */
    private string $transactionId;

    /**
     * 来自App Store的原始数据
     * @var array
     */
    private array $rawBody = [];
    private string $environment;

    /**
     * @param string $originalTransactionId
     * @param string $productId
     * @param int $quantity
     * @param string $transactionId
     * @deprecated Use LatestReceiptInfo::fromArray() instead.
     */
    public function __construct(string $originalTransactionId, string $productId, int $quantity, string $transactionId)
    {
        $this->originalTransactionId = $originalTransactionId;
        $this->productId = $productId;
        $this->quantity = $quantity;
        $this->transactionId = $transactionId;
    }

    /**
     * @param array $attributes
     *
     * @return static
     */
    public static function fromArray(array $attributes, string $environment = self::ENVIRONMENT_PRODUCTION): self
    {
        $obj = new self(
            $attributes['original_transaction_id'],
            $attributes['product_id'],
            (int)$attributes['quantity'],
            $attributes['transaction_id']
        );

        $obj->rawBody = $attributes;

        $obj->appAccountToken = $attributes['app_account_token'] ?? null;
        $obj->cancellationDate = isset($attributes['cancellation_date_ms']) ? (int)$attributes['cancellation_date_ms'] : null;
        $obj->cancellationReason = isset($attributes['cancellation_reason']) ? (int)$attributes['cancellation_reason'] : null;
        $obj->expiresDate = isset($attributes['expires_date_ms']) ? (int)$attributes['expires_date_ms'] : null;
        $obj->inAppOwnershipType = $attributes['in_app_ownership_type'] ?? null;
        $obj->isInIntroOfferPeriod = $attributes['is_in_intro_offer_period'] ?? null;
        $obj->isTrialPeriod = $attributes['is_trial_period'] ?? null;
        $obj->isUpgraded = $attributes['is_upgraded'] ?? null;
        $obj->offerCodeRefName = $attributes['offer_code_ref_name'] ?? null;
        $obj->originalPurchaseDate = isset($attributes['original_purchase_date_ms']) ? (int)$attributes['original_purchase_date_ms'] : null;
        $obj->promotionalOfferId = $attributes['promotional_offer_id'] ?? null;
        $obj->purchaseDate = isset($attributes['purchase_date_ms']) ? (int)$attributes['purchase_date_ms'] : null;
        $obj->subscriptionGroupIdentifier = $attributes['subscription_group_identifier'] ?? null;
        $obj->webOrderLineItemId = $attributes['web_order_line_item_id'] ?? null;
        $obj->environment = $environment;
        return $obj;
    }

    /**
     * @return Time|null
     */
    public function getExpiresDate(): ?Time
    {
        return $this->expiresDate ?
            new Time($this->expiresDate) :
            null;
    }

    public function getExpiresDateString(): ?string
    {
        if (!$this->expiresDate) {
            return null;
        }
        return (new Time($this->expiresDate))->toDateTimeString();
    }

    public function getEnvironment(): string
    {
        return $this->environment;
    }

    /**
     * @return Time|null
     */
    public function getOriginalPurchaseDate(): ?Time
    {
        return $this->originalPurchaseDate ?
            new Time($this->originalPurchaseDate) :
            null;
    }

    /**
     * @return string
     */
    public function getOriginalTransactionId(): string
    {
        return $this->originalTransactionId;
    }

    /**
     * @return string
     */
    public function getProductId(): string
    {
        return $this->productId;
    }

    /**
     * @return Time|null
     */
    public function getPurchaseDate(): ?Time
    {
        return $this->purchaseDate ?
            new Time($this->purchaseDate) :
            null;
    }

    public function getPurchaseDateString(): ?string
    {
        if (!$this->purchaseDate) {
            return null;
        }
        return (new Time($this->purchaseDate))->toDateTimeString();
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @return string|null
     */
    public function getSubscriptionGroupIdentifier(): ?string
    {
        return $this->subscriptionGroupIdentifier;
    }

    /**
     * @return string
     */
    public function getTransactionId(): string
    {
        return $this->transactionId;
    }

    /**
     * @return string|null
     */
    public function getWebOrderLineItemId(): ?string
    {
        return $this->webOrderLineItemId;
    }

    /**
     * @return Time|null
     */
    public function getCancellationDate(): ?Time
    {
        return $this->cancellationDate ?
            new Time($this->cancellationDate) :
            null;
    }

    /**
     * @return int|null
     */
    public function getCancellationReason(): ?int
    {
        return $this->cancellationReason;
    }

    /**
     * @return string|null
     */
    public function getPromotionalOfferId(): ?string
    {
        return $this->promotionalOfferId;
    }

    /**
     * @return string|null
     */
    public function getOfferCodeRefName(): ?string
    {
        return $this->offerCodeRefName;
    }

    /**
     * @return Cancellation|null
     * @deprecated use LatestReceiptInfo::getCancellationReason()
     * @deprecated use LatestReceiptInfo::getCancellationDate()
     */
    public function getCancellation(): ?Cancellation
    {
        if (!is_null($this->cancellationDate) && !is_null($this->cancellationReason)) {
            return new Cancellation($this->getCancellationDate(), $this->getCancellationReason());
        }

        return null;
    }

    /**
     * @return string|null
     */
    public function getAppAccountToken(): ?string
    {
        return $this->appAccountToken;
    }

    /**
     * @return string|null
     */
    public function getInAppOwnershipType(): ?string
    {
        return $this->inAppOwnershipType;
    }

    /**
     * @return bool|null
     */
    public function getIsInIntroOfferPeriod(): ?bool
    {
        if (is_string($this->isInIntroOfferPeriod)) {
            return strtolower($this->isInIntroOfferPeriod) === self::TRUE;
        }

        return $this->isInIntroOfferPeriod;
    }

    /**
     * @return bool|null
     */
    public function getIsTrialPeriod(): ?bool
    {
        if (is_string($this->isTrialPeriod)) {
            return strtolower($this->isTrialPeriod) === self::TRUE;
        }

        return $this->isTrialPeriod;
    }

    /**
     * @return bool|null
     */
    public function getIsUpgraded(): ?bool
    {
        if (is_string($this->isUpgraded)) {
            return strtolower($this->isUpgraded) === self::TRUE;
        }

        return $this->isUpgraded;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return $this->rawBody;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
