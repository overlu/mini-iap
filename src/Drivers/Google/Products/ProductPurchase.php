<?php
/**
 * This file is part of Mini Iap.
 * @auth lupeng
 */
declare(strict_types=1);

namespace MiniIap\Drivers\Google\Products;

use MiniIap\Drivers\Google\ValueObjects\Time;
use JsonSerializable;

/**
 * Class ProductPurchase
 * @package MiniIap\Drivers\Google\Products
 * @see https://developers.google.com/android-publisher/api-ref/rest/v3/purchases.products#ProductPurchase
 */
class ProductPurchase implements JsonSerializable
{
    public const PURCHASE_STATE_PURCHASED = 0;
    public const PURCHASE_STATE_CANCELED = 1;
    public const PURCHASE_STATE_PENDING = 2;

    public const CONSUMPTION_STATE_NOT_CONSUMED = 0;
    public const CONSUMPTION_STATE_CONSUMED = 1;

    public const PURCHASE_TYPE_TEST = 0;
    public const PURCHASE_TYPE_PROMO = 1;
    public const PURCHASE_TYPE_REWARDED = 2;

    public const ACKNOWLEDGEMENT_STATE_NOT_ACKNOWLEDGED = 0;
    public const ACKNOWLEDGEMENT_STATE_ACKNOWLEDGED = 1;

    /**
     * @var string|null
     */
    protected ?string $kind = null;

    /**
     * @var int|null
     */
    protected ?int $purchaseTimeMillis = null;

    /**
     * @var int|null
     */
    protected ?int $purchaseState = null;

    /**
     * @var int|null
     */
    protected ?int $consumptionState = null;

    /**
     * @var string|null
     */
    protected ?string $developerPayload = null;

    /**
     * @var string|null
     */
    protected ?string $orderId = null;

    /**
     * @var int|null
     */
    protected ?int $purchaseType = null;

    /**
     * @var int|null
     */
    protected ?int $acknowledgementState = null;

    /**
     * @var string|null
     */
    protected ?string $purchaseToken = null;

    /**
     * @var string|null
     */
    protected ?string $productId = null;

    /**
     * @var int|null
     */
    protected ?int $quantity = null;

    /**
     * @var string|null
     */
    protected ?string $obfuscatedExternalAccountId = null;

    /**
     * @var string|null
     */
    protected ?string $obfuscatedExternalProfileId = null;

    /**
     * @var string|null
     */
    protected ?string $regionCode = null;

    /**
     * @var array
     */
    protected array $plainResponse = [];

    /**
     * Product Purchase constructor
     * @param array $payload
     */
    public function __construct(array $payload = [])
    {
        $attributes = array_keys(get_class_vars(self::class));
        foreach ($attributes as $attribute) {
            if (isset($payload[$attribute])) {
                $this->$attribute = $payload[$attribute];
            }
        }

        $this->plainResponse = $payload;
    }

    /**
     * @param array $payload
     * @return static
     */
    public static function fromArray(array $payload = []): self
    {
        return new self($payload);
    }

    public function getKind(): ?string
    {
        return $this->kind;
    }

    public function getPurchaseTime(): ?Time
    {
        return
            $this->purchaseTimeMillis ?
                new Time($this->purchaseTimeMillis) :
                null;
    }

    public function getPurchaseTimeMillis(): ?int
    {
        return $this->purchaseTimeMillis;
    }

    public function getPurchaseState(): ?int
    {
        return $this->purchaseState;
    }

    public function getConsumptionState(): ?int
    {
        return $this->consumptionState;
    }

    public function getDeveloperPayload(): ?string
    {
        return $this->developerPayload;
    }

    public function getOrderId(): ?string
    {
        return $this->orderId;
    }

    public function getPurchaseType(): ?int
    {
        return $this->purchaseType;
    }

    public function getAcknowledgementState(): ?int
    {
        return $this->acknowledgementState;
    }

    public function getPurchaseToken(): ?string
    {
        return $this->purchaseToken;
    }

    public function getProductId(): ?string
    {
        return $this->productId;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function getObfuscatedExternalAccountId(): ?string
    {
        return $this->obfuscatedExternalAccountId;
    }

    public function getObfuscatedExternalProfileId(): ?string
    {
        return $this->obfuscatedExternalProfileId;
    }

    public function getRegionCode(): ?string
    {
        return $this->regionCode;
    }

    public function getPlainResponse(): array
    {
        return $this->plainResponse;
    }

    public function toArray(): array
    {
        return $this->getPlainResponse();
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
