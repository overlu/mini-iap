<?php
/**
 * This file is part of Mini Iap.
 * @auth lupeng
 */
declare(strict_types=1);

namespace MiniIap\Subscriptions;

use MiniIap\Contracts\SubscriptionContract;
use MiniIap\Drivers\Google\ClientFactory;
use MiniIap\Drivers\Google\Subscriptions\SubscriptionClient;
use MiniIap\Drivers\Google\Subscriptions\SubscriptionPurchase;
use MiniIap\Drivers\Google\ValueObjects\EmptyResponse;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;

/**
 * Class Google
 * @package MiniIap\Subscriptions
 */
class Google
{
    protected ?string $itemId = null;

    protected ?string $token = null;

    protected ?ClientInterface $client = null;

    protected ?string $packageName = null;

    protected ?SubscriptionPurchase $googleGetResponse = null;

    public function __construct(?ClientInterface $client = null)
    {
        $this->client = $client ?? ClientFactory::create([ClientFactory::SCOPE_ANDROID_PUBLISHER]);
        $this->packageName = config('iap.google-play.package_name');
    }

    public function itemId(string $itemId): self
    {
        $this->itemId = $itemId;

        return $this;
    }

    public function token(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function packageName(string $packageName): self
    {
        $this->packageName = $packageName;

        return $this;
    }

    /**
     * @throws GuzzleException
     */
    public function acknowledge(?string $developerPayload = null): EmptyResponse
    {
        return $this->createSubscription()->acknowledge($developerPayload);
    }

    public function createSubscription(): SubscriptionClient
    {
        return new SubscriptionClient(
            $this->client,
            $this->packageName,
            $this->itemId,
            $this->token
        );
    }

    /**
     * @return SubscriptionContract
     * @throws GuzzleException
     */
    public function toStd(): SubscriptionContract
    {
        $response = $this->get();

        return new GoogleSubscription($response, $this->itemId, $this->token);
    }

    /**
     * @throws GuzzleException
     */
    public function get(): SubscriptionPurchase
    {
        if (is_null($this->googleGetResponse)) {
            $this->googleGetResponse = $this->createSubscription()->get();
        }

        return $this->googleGetResponse;
    }

    /**
     * @throws GuzzleException
     */
    public function cancel(): EmptyResponse
    {
        return $this->createSubscription()->cancel();
    }
}