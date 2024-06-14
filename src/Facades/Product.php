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
 * @method static \MiniIap\Products\Google googlePlay(?ClientInterface $client = null)
 * @method static \MiniIap\Products\Apple appStore(?ClientInterface $client = null)
 */
class Product extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'iap.product';
    }
}