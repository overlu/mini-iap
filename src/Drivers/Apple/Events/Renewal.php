<?php
/**
 * This file is part of Mini Iap.
 * @auth lupeng
 */
declare(strict_types=1);

namespace MiniIap\Drivers\Apple\Events;

use MiniIap\Events\PurchaseEvent;
use MiniIap\Notifications\AppStoreServerNotification;

/**
 * @deprecated use \MiniIap\Drivers\Apple\Events\DidRecover instead
 * @see DidRecover
 *
 * @method AppStoreServerNotification getServerNotification()
 */
class Renewal extends PurchaseEvent
{
}
