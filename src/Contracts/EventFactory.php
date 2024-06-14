<?php
/**
 * This file is part of Mini Iap.
 * @auth lupeng
 */
declare(strict_types=1);

namespace MiniIap\Contracts;

interface EventFactory
{
    public function create(ServerNotificationContract $notification): PurchaseEventContract;
}
