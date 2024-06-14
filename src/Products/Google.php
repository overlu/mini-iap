<?php
/**
 * This file is part of Mini Iap.
 * @auth lupeng
 */
declare(strict_types=1);

namespace MiniIap\Products;

use MiniIap\Drivers\Google\ClientFactory;
use MiniIap\Drivers\Google\Products\ProductClient;
use MiniIap\Drivers\Google\Products\ProductPurchase;
use MiniIap\Drivers\Google\ValueObjects\EmptyResponse;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;

/**
 * Class Google
 * @package MiniIap\Products
 */
class Google
{
    protected string $itemId = '';

    protected string $token = '';

    protected ?ClientInterface $client = null;

    protected string $packageName = '';

    public function __construct(?ClientInterface $client = null)
    {
        $this->client = $client ?? ClientFactory::create([ClientFactory::SCOPE_ANDROID_PUBLISHER]);
        $this->packageName = config('iap.google-play.package_name');
    }

    /**
     * @param string $packageName
     * @return $this
     */
    public function packageName(string $packageName): self
    {
        $this->packageName = $packageName;

        return $this;
    }

    public function id(string $itemId): self
    {
        $this->itemId = $itemId;

        return $this;
    }

    public function token(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    /**
     * @throws GuzzleException
     */
    public function get(): ProductPurchase
    {
        return $this->createProduct()->get();
    }

    public function createProduct(): ProductClient
    {
        assert(!is_null($this->client));

        return new ProductClient(
            $this->client,
            $this->packageName,
            $this->itemId,
            $this->token
        );
    }

    /**
     * @throws GuzzleException
     */
    public function acknowledge(?string $developerPayload = null): EmptyResponse
    {
        return $this->createProduct()->acknowledge($developerPayload);
    }

    /**
     * @throws GuzzleException
     */
    public function consume(): EmptyResponse
    {
        return $this->createProduct()->consume();
    }
}