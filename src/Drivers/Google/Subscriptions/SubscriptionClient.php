<?php
/**
 * This file is part of Mini Iap.
 * @auth lupeng
 */
declare(strict_types=1);

namespace MiniIap\Drivers\Google\Subscriptions;

use MiniIap\Drivers\Google\ValueObjects\EmptyResponse;
use MiniIap\Drivers\Google\ValueObjects\SubscriptionDeferralInfo;
use MiniIap\Drivers\Google\ValueObjects\Time;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;

/**
 * Class SubscriptionClient
 * @package MiniIap\Drivers\Google\Subscriptions
 */
class SubscriptionClient
{
    public const URI_GET = 'https://androidpublisher.googleapis.com/androidpublisher/v3/applications/%s/purchases/subscriptions/%s/tokens/%s';
    public const URI_ACKNOWLEDGE = 'https://androidpublisher.googleapis.com/androidpublisher/v3/applications/%s/purchases/subscriptions/%s/tokens/%s:acknowledge';
    public const URI_CANCEL = 'https://androidpublisher.googleapis.com/androidpublisher/v3/applications/%s/purchases/subscriptions/%s/tokens/%s:cancel';
    public const URI_DEFER = 'https://androidpublisher.googleapis.com/androidpublisher/v3/applications/%s/purchases/subscriptions/%s/tokens/%s:defer';
    public const URI_REFUND = 'https://androidpublisher.googleapis.com/androidpublisher/v3/applications/%s/purchases/subscriptions/%s/tokens/%s:refund';
    public const URI_REVOKE = 'https://androidpublisher.googleapis.com/androidpublisher/v3/applications/%s/purchases/subscriptions/%s/tokens/%s:revoke';

    /**
     * @var ClientInterface
     */
    protected ClientInterface $client;

    /**
     * @var string
     */
    protected string $packageName;

    /**
     * @var string
     */
    protected string $subscriptionId;

    /**
     * @var string
     */
    protected string $token;

    /**
     * Subscription constructor.
     */
    public function __construct(ClientInterface $client, string $packageName, string $subscriptionId, string $token)
    {
        $this->client = $client;
        $this->packageName = $packageName;
        $this->subscriptionId = $subscriptionId;
        $this->token = $token;
    }

    /**
     * - simulates the API behaviour
     * - Get request was not consistent as it was acknowledged.
     *
     * @throws GuzzleException
     */
    public function acknowledge(?string $developerPayload = null): EmptyResponse
    {
        $uri = $this->getEndpoint(self::URI_ACKNOWLEDGE);
        $options = [
            'form_params' => [
                'developerPayload' => $developerPayload,
            ],
        ];

        return new EmptyResponse($this->client->post($uri, $options));
    }

    /**
     * @throws GuzzleException
     */
    public function cancel(): EmptyResponse
    {
        $uri = $this->getEndpoint(self::URI_CANCEL);

        return new EmptyResponse($this->client->post($uri));
    }

    /**
     * @throws GuzzleException
     */
    public function defer(SubscriptionDeferralInfo $subscriptionDeferralInfo): Time
    {
        $uri = $this->getEndpoint(self::URI_DEFER);
        $options = [
            'json' => [
                'deferralInfo' => $subscriptionDeferralInfo->toArray(),
            ],
        ];
        $response = $this->client->post($uri, $options);
        $newExpiryTime = json_decode((string)$response->getBody(), true)['newExpiryTimeMillis'];

        return new Time($newExpiryTime);
    }

    /**
     * @throws GuzzleException
     */
    public function get(): SubscriptionPurchase
    {
        $uri = $this->getEndpoint(self::URI_GET);
        $response = $this->client->get($uri);
        $responseBody = json_decode((string)$response->getBody(), true);

        return SubscriptionPurchase::fromArray($responseBody);
    }

    /**
     * @throws GuzzleException
     */
    public function refund(): EmptyResponse
    {
        $uri = $this->getEndpoint(self::URI_REFUND);

        return new EmptyResponse($this->client->post($uri));
    }

    /**
     * @throws GuzzleException
     */
    public function revoke(): EmptyResponse
    {
        $uri = $this->getEndpoint(self::URI_REVOKE);

        return new EmptyResponse($this->client->post($uri));
    }

    private function getEndpoint(string $template): string
    {
        return sprintf($template, $this->packageName, $this->subscriptionId, $this->token);
    }
}
