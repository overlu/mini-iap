<?php
/**
 * This file is part of Mini Iap.
 * @auth lupeng
 */
declare(strict_types=1);

namespace MiniIap\Drivers\Apple;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;

/**
 * Class ClientFactory
 * @package MiniIap\Drivers\Apple
 */
class ClientFactory
{
    public const BASE_URI = 'https://buy.itunes.apple.com';
    public const BASE_URI_SANDBOX = 'https://sandbox.itunes.apple.com';

    public const STORE_KIT_PRODUCTION_URI = 'https://api.storekit.itunes.apple.com';
    public const STORE_KIT_SANDBOX_URI = 'https://api.storekit-sandbox.itunes.apple.com';

    /**
     * @param bool $sandbox
     * @param array $options
     * @return ClientInterface
     */
    public static function create(bool $sandbox = false, array $options = []): ClientInterface
    {
        if (empty($options['base_uri'])) {
            $options['base_uri'] = $sandbox ? self::BASE_URI_SANDBOX : self::BASE_URI;
        }

        return new Client($options);
    }

    /**
     * @return ClientInterface
     */
    public static function createSandbox(): ClientInterface
    {
        return self::create(true);
    }
}
