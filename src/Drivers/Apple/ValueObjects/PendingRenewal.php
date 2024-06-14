<?php
/**
 * This file is part of Mini Iap.
 * @auth lupeng
 */
declare(strict_types=1);

namespace MiniIap\Drivers\Apple\ValueObjects;

/**
 * Class PendingRenewal
 * 指未完成或失败的自动续订
 * @see https://developer.apple.com/documentation/appstorereceipts/responsebody/pending_renewal_info
 * @package App\Payment\Apple\ValueObjects
 */
final class PendingRenewal
{
    public const STILL_ATTEMPTING_TO_RENEW = 1;
    public const STOPPED_ATTEMPTING_TO_RENEW = 0;

    public const PRICE_INCREASE_CONSENT = "1";
    public const PRICE_INCREASE_NOT_CONSENT = "0";

    /**
     * 此密钥的值对应于客户的订阅续订的产品的productIdentifier属性。
     * @see https://developer.apple.com/documentation/storekit/skpayment/1506155-productidentifier
     * @var string
     */
    private string $autoRenewProductId;

    /**
     * 自动续订订阅的当前续订状态。
     * @see AutoRenewStatus
     * @see https://developer.apple.com/documentation/appstorereceipts/auto_renew_status?changes=latest_minor
     * @var int|null
     */
    private ?int $autoRenewStatus;

    /**
     * 订阅过期的原因。此字段仅适用于包含过期的自动续订订阅的收据
     * @see https://developer.apple.com/documentation/appstorereceipts/expiration_intent
     * @see ExpirationIntent
     * @var int|null
     */
    private ?int $expirationIntent;

    /**
     * 续订宽限期到期的时间，以UNIX epoch时间格式为单位，以毫秒为单位
     * @var int|null
     */
    private ?int $gracePeriodExpiresDate;

    /**
     * 一个标志，表示苹果正在尝试自动续订过期的订阅。
     * @see https://developer.apple.com/documentation/appstorereceipts/is_in_billing_retry_period?changes=latest_minor
     * @var int|null
     */
    private ?int $isInBillingRetryPeriod;

    /**
     * 您在App Store Connect中配置的订阅优惠的参考名称。当客户兑换订阅优惠代码时，会出现此字段。
     * @var string|null
     * @see https://developer.apple.com/documentation/appstorereceipts/offer_code_ref_name?changes=latest_minor
     */
    private ?string $offerCodeRefName;

    /**
     * 原始购买的交易标识符。
     * @see https://developer.apple.com/documentation/appstorereceipts/original_transaction_id?changes=latest_minor
     * @var string
     */
    private string $originalTransactionId;

    /**
     * 订阅价格上涨的价格同意状态。只有当通知客户价格上涨时，此字段才会出现。
     * 默认值为“0”，如果客户同意，则更改为“1”。
     * ->->根据值，它应该是整数，但苹果文档描述了这个密钥字符串。
     * @var string|null
     */
    private ?string $priceConsentStatus;

    /**
     * 购买产品的唯一标识符。您在App Store Connect中创建产品时提供此值，并且它对应于存储在交易的支付属性中的SKPayment对象的productIdentifier属性。
     * @see https://developer.apple.com/documentation/storekit/skpayment?changes=latest_minor
     * @var string
     */
    private string $productId;

    /**
     * 用户兑换的自动续订的促销优惠的标识符。当您在App Store Connect中创建促销优惠时，您可以在促销优惠标识符字段中提供此值。
     * @see https://developer.apple.com/documentation/appstorereceipts/promotional_offer_id
     * @var string|null
     */
    private ?string $promotionalOfferId;

    /**
     * @param string $autoRenewProductId
     * @param string $originalTransactionId
     * @param string $productId
     */
    public function __construct(string $autoRenewProductId, string $originalTransactionId, string $productId)
    {
        $this->autoRenewProductId = $autoRenewProductId;
        $this->originalTransactionId = $originalTransactionId;
        $this->productId = $productId;
    }

    /**
     * @param array $attributes
     * @return static
     */
    public static function fromArray(array $attributes): self
    {
        $obj = new self(
            $attributes['auto_renew_product_id'],
            $attributes['original_transaction_id'],
            $attributes['product_id']
        );

        $obj->autoRenewStatus = $attributes['auto_renew_status'] ?? null;
        $obj->expirationIntent = isset($attributes['expiration_intent']) ? (int)$attributes['expiration_intent'] : null;
        $obj->gracePeriodExpiresDate = $attributes['grace_period_expires_date_ms'] ?? null;
        $obj->isInBillingRetryPeriod = $attributes['is_in_billing_retry_period'] ?? null;
        $obj->offerCodeRefName = $attributes['offer_code_ref_name'] ?? null;
        $obj->priceConsentStatus = $attributes['price_consent_status'] ?? null;
        $obj->promotionalOfferId = $attributes['promotional_offer_id'] ?? null;

        return $obj;
    }


    /**
     * @return int|null
     */
    public function getIsInBillingRetryPeriod(): ?int
    {
        return $this->isInBillingRetryPeriod;
    }

    /**
     * @return string
     */
    public function getAutoRenewProductId(): string
    {
        return $this->autoRenewProductId;
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
    public function getGracePeriodExpiresDate(): ?Time
    {
        return
            is_null($this->gracePeriodExpiresDate) ?
                null :
                new Time($this->gracePeriodExpiresDate);
    }

    /**
     * @return string|null
     */
    public function getOfferCodeRefName(): ?string
    {
        return $this->offerCodeRefName;
    }

    /**
     * @return int|null
     */
    public function getExpirationIntent(): ?int
    {
        return $this->expirationIntent;
    }

    /**
     * @return int|null
     */
    public function getAutoRenewStatus(): ?int
    {
        return $this->autoRenewStatus;
    }

    /**
     * @return string|null
     */
    public function getPriceConsentStatus(): ?string
    {
        return $this->priceConsentStatus;
    }

    /**
     * @return string|null
     */
    public function getPromotionalOfferId(): ?string
    {
        return $this->promotionalOfferId;
    }
}
