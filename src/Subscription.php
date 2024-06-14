<?php
/**
 * This file is part of Mini Iap.
 * @auth lupeng
 * @date 2024/6/11 13:47
 */
declare(strict_types=1);

namespace MiniIap;

use MiniIap\Subscriptions\Apple;
use MiniIap\Subscriptions\Google;
use GuzzleHttp\ClientInterface;

class Subscription
{
    /**
     * @param ClientInterface|null $client
     * @return Google
     */
    public function googlePlay(?ClientInterface $client = null): Google
    {
        return new Google($client);
    }

    /**
     * @param ClientInterface|null $client
     * @return Apple
     */
    public function appStore(?ClientInterface $client = null): Apple
    {
        return new Apple($client);
    }
}
