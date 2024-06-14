<?php
/**
 * This file is part of Mini Iap.
 * @auth lupeng
 */
declare(strict_types=1);

namespace MiniIap\Drivers\Google\Subscriptions;

use MiniIap\Drivers\Google\ValueObjects\Cancellation;
use MiniIap\Drivers\Google\ValueObjects\IntroductoryPriceInfo;
use MiniIap\Drivers\Google\ValueObjects\Price;
use MiniIap\Drivers\Google\ValueObjects\SubscriptionPriceChange;
use MiniIap\Drivers\Google\ValueObjects\Time;
use JsonSerializable;

/**
 * Class SubscriptionPurchase
 * Subscription purchase class
 * A SubscriptionPurchase resource indicates the status of a user's subscription purchase.
 * @see https://developers.google.com/android-publisher/api-ref/rest/v3/purchases.subscriptions#SubscriptionPurchase
 * @package MiniIap\Drivers\Google\Subscriptions
 */
class SubscriptionPurchase implements JsonSerializable
{
    /**
     *
     */
    public const PURCHASE_TYPE_TEST = 0;
    public const PURCHASE_TYPE_PROMO = 1;

    public const ACKNOWLEDGEMENT_STATE_NOT_ACKNOWLEDGED = 0;
    public const ACKNOWLEDGEMENT_STATE_ACKNOWLEDGED = 1;

    public const PROMOTION_TYPE_VANITY_CODE = 1;
    public const PROMOTION_TYPE_ONE_TIME_CODE = 0;

    public const PAYMENT_STATE_FREE_TRIAL = 2;
    public const PAYMENT_STATE_PENDING = 0;
    public const PAYMENT_STATE_DEFERRED = 3;
    public const PAYMENT_STATE_RECEIVED = 1;

    /**
     * @var string|null
     */
    protected ?string $kind = null;

    /**
     * @var int|null
     */
    protected ?int $startTimeMillis = null;

    /**
     * @var int|null
     */
    protected ?int $expiryTimeMillis = null;

    /**
     * @var int|null
     */
    protected ?int $autoResumeTimeMillis = null;

    /**
     * @var bool|null
     */
    protected ?bool $autoRenewing = null;

    /**
     * @var string|null
     */
    protected ?string $priceCurrencyCode = null;

    /**
     * @var int|null
     */
    protected ?int $priceAmountMicros = null;

    /**
     * @var array|null
     */
    protected ?array $introductoryPriceInfo = null;

    /**
     * @var string|null
     */
    protected ?string $countryCode = null;

    /**
     * @var string|null
     */
    protected ?string $developerPayload = null;

    /**
     * @var int|null
     */
    protected ?int $paymentState = null;

    /**
     * @var int|null
     */
    protected ?int $cancelReason = null;

    /**
     * @var int|null
     */
    protected ?int $userCancellationTimeMillis = null;

    /**
     * @var array|null
     */
    protected ?array $cancelSurveyResult = null;

    /**
     * @var string|null
     */
    protected ?string $orderId = null;

    /**
     * @var string|null
     */
    protected ?string $linkedPurchaseToken = null;

    /**
     * @var int|null
     */
    protected ?int $purchaseType = null;

    /**
     * @var array|null
     */
    protected ?array $priceChange = null;

    /**
     * @var string|null
     */
    protected ?string $profileName = null;

    /**
     * @var string|null
     */
    protected ?string $emailAddress = null;

    /**
     * @var string|null
     */
    protected ?string $givenName = null;

    /**
     * @var string|null
     */
    protected ?string $familyName = null;

    /**
     * @var string|null
     */
    protected ?string $profileId = null;

    /**
     * @var int|null
     */
    protected ?int $acknowledgementState = null;

    /**
     * @var string|null
     */
    protected ?string $externalAccountId = null;

    /**
     * @var int|null
     */
    protected ?int $promotionType = null;

    /**
     * @var string|null
     */
    protected ?string $promotionCode = null;

    /**
     * @var string|null
     */
    protected ?string $obfuscatedExternalAccountId = null;

    /**
     * @var string|null
     */
    protected ?string $obfuscatedExternalProfileId = null;

    /**
     * @var array
     */
    protected array $plainResponse = [];

    /**
     * @param array $responseBody
     */
    public function __construct(array $responseBody = [])
    {
        $attributes = array_keys(get_class_vars(self::class));

        foreach ($attributes as $attribute) {
            if (isset($responseBody[$attribute])) {
                $this->$attribute = $responseBody[$attribute];
            }
        }

        $this->plainResponse = $responseBody;
    }

    public static function fromArray(array $responseBody): self
    {
        return new self($responseBody);
    }

    /**
     * @return string|null
     */
    public function getKind(): ?string
    {
        return $this->kind;
    }

    /**
     * @return bool|null
     */
    public function isAutoRenewing(): ?bool
    {
        return $this->autoRenewing;
    }

    /**
     * @return string|null
     */
    public function getPriceCurrencyCode(): ?string
    {
        return $this->priceCurrencyCode;
    }

    /**
     * @return int|null
     */
    public function getPriceAmountMicros(): ?int
    {
        return $this->priceAmountMicros;
    }

    /**
     * @return string|null
     */
    public function getCountryCode(): ?string
    {
        return $this->countryCode;
    }

    /**
     * @return string|null
     */
    public function getDeveloperPayload(): ?string
    {
        return $this->developerPayload;
    }

    /**
     * @return string|null
     */
    public function getOrderId(): ?string
    {
        return $this->orderId;
    }

    /**
     * @return string|null
     */
    public function getLinkedPurchaseToken(): ?string
    {
        return $this->linkedPurchaseToken;
    }

    /**
     * @return string|null
     */
    public function getEmailAddress(): ?string
    {
        return $this->emailAddress;
    }

    /**
     * @return string|null
     */
    public function getGivenName(): ?string
    {
        return $this->givenName;
    }

    /**
     * @return string|null
     */
    public function getProfileId(): ?string
    {
        return $this->profileId;
    }

    /**
     * @return string|null
     */
    public function getExternalAccountId(): ?string
    {
        return $this->externalAccountId;
    }

    /**
     * @return string|null
     */
    public function getObfuscatedExternalAccountId(): ?string
    {
        return $this->obfuscatedExternalAccountId;
    }

    /**
     * @return string|null
     */
    public function getObfuscatedExternalProfileId(): ?string
    {
        return $this->obfuscatedExternalProfileId;
    }

    /**
     * @return Time|null
     */
    public function getStartTime(): ?Time
    {
        return is_null($this->startTimeMillis) ? null : new Time($this->startTimeMillis);
    }

    /**
     * @return Time|null
     */
    public function getExpiryTime(): ?Time
    {
        return is_null($this->expiryTimeMillis) ? null : new Time($this->expiryTimeMillis);
    }

    /**
     * @return Time|null
     */
    public function getAutoResumeTime(): ?Time
    {
        return is_null($this->autoResumeTimeMillis) ? null : new Time($this->autoResumeTimeMillis);
    }

    /**
     * @return IntroductoryPriceInfo|null
     */
    public function getIntroductoryPriceInfo(): ?IntroductoryPriceInfo
    {
        return is_null($this->introductoryPriceInfo) ?
            null :
            IntroductoryPriceInfo::fromArray($this->introductoryPriceInfo);
    }

    /**
     * @return SubscriptionPriceChange|null
     */
    public function getPriceChange(): ?SubscriptionPriceChange
    {
        if (is_null($this->priceChange)) {
            return null;
        }

        $newPrice = Price::fromArray($this->priceChange['newPrice']);
        $state = $this->priceChange['state'];

        return new SubscriptionPriceChange($newPrice, $state);
    }

    /**
     * @return Cancellation|null
     */
    public function getCancellation(): ?Cancellation
    {
        $noCancellationData =
            is_null($this->cancelReason)
            && is_null($this->userCancellationTimeMillis)
            && is_null($this->cancelSurveyResult);

        if ($noCancellationData) {
            return null;
        }

        return Cancellation::fromArray([
            Cancellation::ATTR_CANCEL_REASON => $this->cancelReason,
            Cancellation::ATTR_USER_CANCELLATION_TIME_MILLIS => $this->userCancellationTimeMillis,
            Cancellation::ATTR_cancelSurveyResult => $this->cancelSurveyResult,
        ]);
    }

    /**
     * @return int|null
     */
    public function getAcknowledgementState(): ?int
    {
        return $this->acknowledgementState;
    }

    /**
     * @return int|null
     */
    public function getPaymentState(): ?int
    {
        return $this->paymentState;
    }

    /**
     * @return int|null
     */
    public function getPurchaseType(): ?int
    {
        return $this->purchaseType;
    }

    /**
     * @return string|null
     */
    public function getProfileName(): ?string
    {
        return $this->profileName;
    }

    /**
     * @return string|null
     */
    public function getFamilyName(): ?string
    {
        return $this->familyName;
    }

    /**
     * @return array
     */
    public function getPlainResponse(): array
    {
        return $this->plainResponse;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->getPlainResponse();
    }

    /**
     * @return int|null
     */
    public function getPromotionType(): ?int
    {
        return $this->promotionType;
    }

    /**
     * @return string|null
     */
    public function getPromotionCode(): ?string
    {
        return $this->promotionCode;
    }

    public function getStartTimeMillis(): ?int
    {
        return $this->startTimeMillis;
    }

    public function getExpiryTimeMillis(): ?int
    {
        return $this->expiryTimeMillis;
    }

    public function getAutoResumeTimeMillis(): ?int
    {
        return $this->autoResumeTimeMillis;
    }

    public function getAutoRenewing(): ?bool
    {
        return $this->autoRenewing;
    }

    public function getCancelReason(): ?int
    {
        return $this->cancelReason;
    }

    public function getUserCancellationTimeMillis(): ?int
    {
        return $this->userCancellationTimeMillis;
    }

    public function getCancelSurveyResult(): ?array
    {
        return $this->cancelSurveyResult;
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
