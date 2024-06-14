<?php
/**
 * This file is part of Mini Iap.
 * @auth lupeng
 */
declare(strict_types=1);

namespace MiniIap\Drivers\Apple\Events;

use MiniIap\Events\PurchaseEvent;
use MiniIap\Notifications\AppStoreV2ServerNotification;

/**
 * @method AppStoreV2ServerNotification getServerNotification()
 */
class PriceIncrease extends PurchaseEvent
{
}
