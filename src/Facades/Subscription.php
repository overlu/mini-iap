<?php
/**
 * This file is part of Mini Iap.
 * @auth lupeng
 */
declare(strict_types=1);

namespace MiniIap\Facades;

use GuzzleHttp\ClientInterface;
use Mini\Facades\Facade;

/**
 * @method static \MiniIap\Subscriptions\Google googlePlay(?ClientInterface $client = null)
 * @method static \MiniIap\Subscriptions\Apple appStore(?ClientInterface $client = null)
 */
class Subscription extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'iap.subscription';
    }
}