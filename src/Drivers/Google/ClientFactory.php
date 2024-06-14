<?php
/**
 * This file is part of Mini Iap.
 * @auth lupeng
 */
declare(strict_types=1);

namespace MiniIap\Drivers\Google;

use Google\Auth\ApplicationDefaultCredentials;
use Google\Auth\CredentialsLoader;
use Google\Auth\Middleware\AuthTokenMiddleware;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\HandlerStack;

/**
 * Class ClientFactory is responsible for creating an HTTP client for
 * different use cases.
 */
class ClientFactory
{
    public const SCOPE_ANDROID_PUBLISHER = 'https://www.googleapis.com/auth/androidpublisher';
    private const BASE_URI = 'https://www.googleapis.com';
    private const GOOGLE_AUTH = 'google_auth';

    /**
     * @param array $scopes
     * @return ClientInterface
     */
    public static function create(array $scopes = [self::SCOPE_ANDROID_PUBLISHER]): ClientInterface
    {
        $middleware = ApplicationDefaultCredentials::getMiddleware($scopes);

        return self::createWithMiddleware($middleware);
    }

    /**
     * @param array $jsonKey
     * @param array $scopes
     * @return ClientInterface
     */
    public static function createWithJsonKey(
        array $jsonKey,
        array $scopes = [self::SCOPE_ANDROID_PUBLISHER]
    ): ClientInterface {
        $credentials = CredentialsLoader::makeCredentials($scopes, $jsonKey);
        $middleware = new AuthTokenMiddleware($credentials);

        return self::createWithMiddleware($middleware);
    }

    /**
     * @param AuthTokenMiddleware $middleware
     * @return ClientInterface
     */
    public static function createWithMiddleware(AuthTokenMiddleware $middleware): ClientInterface
    {
        $stack = HandlerStack::create();
        $stack->push($middleware);

        return new Client([
            'handler' => $stack,
            'base_uri' => self::BASE_URI,
            'auth' => self::GOOGLE_AUTH,
        ]);
    }
}
