<?php
/**
 * This file is part of Mini Iap.
 * @auth lupeng
 */
declare(strict_types=1);

namespace MiniIap\Drivers\Apple\Events;

use MiniIap\Events\PurchaseEvent;
use MiniIap\Notifications\AppStoreServerNotification;
use MiniIap\Notifications\AppStoreV2ServerNotification;

/**
 * @method AppStoreServerNotification|AppStoreV2ServerNotification getServerNotification()
 */
class ConsumptionRequest extends PurchaseEvent
{
}
