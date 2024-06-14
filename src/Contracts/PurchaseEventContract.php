<?php
/**
 * This file is part of Mini Iap.
 * @auth lupeng
 */
declare(strict_types=1);

namespace MiniIap\Contracts;

/**
 * Interface PurchaseEventContract.
 */
interface PurchaseEventContract
{
    public function getServerNotification(): ServerNotificationContract;
}
