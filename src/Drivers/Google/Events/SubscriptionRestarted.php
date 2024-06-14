<?php
/**
 * This file is part of Mini Iap.
 * @auth lupeng
 */
declare(strict_types=1);

namespace MiniIap\Drivers\Google\Events;

use MiniIap\Events\PurchaseEvent;
use MiniIap\Notifications\GoogleServerNotification;

/**
 * @method GoogleServerNotification getServerNotification()
 */
class SubscriptionRestarted extends PurchaseEvent
{
}
