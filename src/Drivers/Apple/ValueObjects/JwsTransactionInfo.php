<?php
/**
 * This file is part of Mini Iap.
 * @auth lupeng
 */
declare(strict_types=1);

namespace MiniIap\Drivers\Apple\ValueObjects;

use MiniIap\Drivers\Apple\Jws\JsonWebSignature;
use MiniIap\Drivers\Apple\Jws\UnEncryptedTokenConcern;

/**
 * Class JwsTransactionInfo
 * 交易信息，由应用商店以JSON Web签名（JWS）格式签名。
 * @link https://developer.apple.com/documentation/appstoreservernotifications/jwstransaction
 * @package App\Payment\Apple\ValueObjects
 */
final class JwsTransactionInfo implements JsonWebSignature
{
    use UnEncryptedTokenConcern;

    public const ENVIRONMENT_SANDBOX = 'Sandbox';
    public const ENVIRONMENT_PRODUCTION = 'Production';

    public const OWNERSHIP_TYPE_FAMILY_SHARED = 'FAMILY_SHARED';
    public const OWNERSHIP_TYPE_PURCHASED = 'PURCHASED';

    public const OFFER_TYPE_INTRODUCTORY = 1;
    public const OFFER_TYPE_PROMOTIONAL = 2;
    public const OFFER_TYPE_SUBSCRIPTION = 3;

    public const REVOCATION_REASON_APP_ISSUE = 1;
    public const REVOCATION_REASON_OTHER = 0;

    public const TYPE_AUTO_RENEWABLE = 'Auto-Renewable Subscription';
    public const TYPE_NON_RENEWING_SUBSCRIPTION = 'Non-Renewing Subscription';
    public const TYPE_NON_CONSUMABLE = 'Non-Consumable';
    public const TYPE_CONSUMABLE = 'Consumable';

    /**
     * @var JsonWebSignature
     */
    private JsonWebSignature $token;

    /**
     * @param JsonWebSignature $token
     */
    public function __construct(JsonWebSignature $token)
    {
        $this->token = $token;
    }

    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        return $this->token->__toString();
    }

    /**
     * Get list of headers
     *
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->token->getHeaders();
    }

    /**
     * Get list of claims
     *
     * @return array
     */
    public function getClaims(): array
    {
        return $this->token->getClaims();
    }

    /**
     * Get signature
     *
     * @return string
     */
    public function getSignature(): string
    {
        return $this->token->getSignature();
    }

    /**
     * @return string|null
     */
    public function getAppAccountToken(): ?string
    {
        return $this->getClaims()['appAccountToken'] ?? null;
    }

    /**
     * @return string|null
     */
    public function getBundleId(): ?string
    {
        return $this->getClaims()['bundleId'] ?? null;
    }

    /**
     * @return string|null
     */
    public function getEnvironment(): ?string
    {
        return $this->getClaims()['environment'] ?? null;
    }

    /**
     * @return Time|null
     */
    public function getExpiresDate(): ?Time
    {
        if (!isset($this->getClaims()['expiresDate'])) {
            return null;
        }

        return new Time($this->getClaims()['expiresDate']);
    }

    public function getExpiresDateString(): ?string
    {
        if (!isset($this->getClaims()['expiresDate'])) {
            return null;
        }

        return (new Time($this->getClaims()['expiresDate']))->toDateTimeString();
    }

    /**
     * @return string|null
     */
    public function getInAppOwnershipType(): ?string
    {
        return $this->getClaims()['inAppOwnershipType'] ?? null;
    }

    /**
     * @return bool|null
     */
    public function getIsUpgraded(): ?bool
    {
        return $this->getClaims()['isUpgraded'] ?? null;
    }

    /**
     * @return string|null
     */
    public function getOfferIdentifier(): ?string
    {
        return $this->getClaims()['offerIdentifier'] ?? null;
    }

    /**
     * @return string|null
     */
    public function getOfferType(): ?string
    {
        return $this->getClaims()['offerType'] ?? null;
    }

    /**
     * @return Time|null
     */
    public function getOriginalPurchaseDate(): ?Time
    {
        if (!isset($this->getClaims()['originalPurchaseDate'])) {
            return null;
        }

        return new Time($this->getClaims()['originalPurchaseDate']);
    }

    public function getOriginalPurchaseDateString(): ?string
    {
        if (!isset($this->getClaims()['originalPurchaseDate'])) {
            return null;
        }

        return (new Time($this->getClaims()['originalPurchaseDate']))->toDateTimeString();
    }

    /**
     * @return string|null
     */
    public function getOriginalTransactionId(): ?string
    {
        return $this->getClaims()['originalTransactionId'] ?? null;
    }

    /**
     * @return string|null
     */
    public function getProductId(): ?string
    {
        return $this->getClaims()['productId'] ?? null;
    }

    /**
     * @return Time|null
     */
    public function getPurchaseDate(): ?Time
    {
        if (!isset($this->getClaims()['purchaseDate'])) {
            return null;
        }

        return new Time($this->getClaims()['purchaseDate']);
    }


    /**
     * @return string
     */
    public function getPurchaseDateString(): ?string
    {
        if (!isset($this->getClaims()['purchaseDate'])) {
            return null;
        }

        return (new Time($this->getClaims()['purchaseDate']))->toDateTimeString();
    }

    /**
     * @return int|null
     */
    public function getQuantity(): ?int
    {
        return $this->getClaims()['quantity'] ?? null;
    }

    /**
     * @return Time|null
     */
    public function getRevocationDate(): ?Time
    {
        if (!isset($this->getClaims()['revocationDate'])) {
            return null;
        }

        return new Time($this->getClaims()['revocationDate']);
    }

    public function getRevocationDateString(): ?string
    {
        if (!isset($this->getClaims()['revocationDate'])) {
            return null;
        }

        return (new Time($this->getClaims()['revocationDate']))->toDateTimeString();
    }

    /**
     * @return int|null
     */
    public function getRevocationReason(): ?int
    {
        return $this->getClaims()['revocationReason'] ?? null;
    }

    /**
     * @return Time|null
     */
    public function getSignedDate(): ?Time
    {
        if (!isset($this->getClaims()['signedDate'])) {
            return null;
        }

        return new Time($this->getClaims()['signedDate']);
    }

    public function getSignedDateString(): ?string
    {
        if (!isset($this->getClaims()['signedDate'])) {
            return null;
        }

        return (new Time($this->getClaims()['signedDate']))->toDateTimeString();
    }

    /**
     * @return string
     */
    public function getSubscriptionGroupIdentifier(): string
    {
        return $this->getClaims()['subscriptionGroupIdentifier'] ?? '';
    }

    /**
     * @return string
     */
    public function getTransactionId(): string
    {
        return $this->getClaims()['transactionId'] ?? '';
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->getClaims()['type'] ?? '';
    }

    /**
     * @return string|null
     */
    public function getWebOrderLineItemId(): ?string
    {
        return $this->getClaims()['webOrderLineItemId'] ?? null;
    }
}
