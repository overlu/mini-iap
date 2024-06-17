<?php
/**
 * This file is part of Mini Iap.
 * @auth lupeng
 */
declare(strict_types=1);

namespace MiniIap\Products;

use MiniIap\Drivers\Apple\Exceptions\InvalidReceiptException;
use MiniIap\Drivers\Apple\Receipts\ReceiptResponse;
use MiniIap\Drivers\Apple\Receipts\Verifier;
use MiniIap\Drivers\Apple\ClientFactory;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;

/**
 * Class Apple
 * @package MiniIap\Products
 */
class Apple
{
    protected ?ClientInterface $client = null;

    protected string $packageName = '';

    protected string $receiptData = '';

    protected string $password = '';

    public function __construct(?ClientInterface $client = null)
    {
        $this->client = $client ?? ClientFactory::create(config('iap.app-store.sandbox'));
        $this->packageName = config('iap.google-play.package_name');
    }

    /**
     * @throws GuzzleException|InvalidReceiptException
     */
    public function verifyReceipt(): ReceiptResponse
    {
        assert(!is_null($this->client));

        return (new Verifier($this->client, $this->receiptData, $this->password))->verify();
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
}