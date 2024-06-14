<?php
/**
 * This file is part of Mini Iap.
 * @auth lupeng
 */
declare(strict_types=1);

namespace MiniIap\Subscriptions;

use MiniIap\Contracts\SubscriptionContract;
use MiniIap\Drivers\Apple\ClientFactory;
use MiniIap\Drivers\Apple\Exceptions\InvalidReceiptException;
use MiniIap\Drivers\Apple\Receipts\ReceiptResponse;
use MiniIap\Drivers\Apple\Receipts\Verifier;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;

class Apple
{
    protected ?ClientInterface $client = null;

    protected ?string $receiptData = null;

    protected ?string $password = null;

    protected bool $renewalAble = false;

    private ?ReceiptResponse $appStoreResponse = null;

    /**
     * @psalm-suppress PropertyTypeCoercion - The client type is compatible
     */
    public function __construct(?ClientInterface $client = null)
    {
        $this->client = $client ?? ClientFactory::create();
        $this->password = config('iap.app-store.password');
        $this->renewalAble = false;
    }

    /**
     * @throws GuzzleException
     * @throws InvalidReceiptException
     */
    public function verifyRenewable(?ClientInterface $sandboxClient = null): ReceiptResponse
    {
        $this->renewalAble = true;

        return $this->verifyReceipt($sandboxClient);
    }

    /**
     * @throws GuzzleException
     * @throws InvalidReceiptException
     */
    public function verifyReceipt(?ClientInterface $sandboxClient = null): ReceiptResponse
    {
        if (is_null($this->appStoreResponse)) {
            assert(! is_null($this->client));
            assert(! is_null($this->receiptData));
            assert(! is_null($this->password));

            $verifier = new Verifier($this->client, $this->receiptData, $this->password);
            $this->appStoreResponse = $verifier->verify($this->renewalAble, $sandboxClient);
        }

        return $this->appStoreResponse;
    }

    public function renewable(): self
    {
        $this->renewalAble = true;

        return $this;
    }

    public function nonRenewable(): self
    {
        $this->renewalAble = false;

        return $this;
    }

    /**
     * @return $this
     */
    public function receiptData(string $receiptData): self
    {
        $this->receiptData = $receiptData;

        return $this;
    }

    /**
     * @return $this
     */
    public function password(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @throws GuzzleException
     * @throws InvalidReceiptException
     *
     * @psalm-suppress  PossiblyNullArgument - This method should not be called if itemId and token are null
     * @psalm-suppress  MixedArgument - We know the type of the latest receipt info
     * @psalm-suppress  PossiblyNullArrayAccess - This method should not be called if the array empty
     */
    public function toStd(): SubscriptionContract
    {
        return new AppStoreSubscription($this->verifyReceipt()->getLatestReceiptInfo(true));
    }
}