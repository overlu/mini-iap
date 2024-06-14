<?php
/**
 * This file is part of Mini Iap.
 * @auth lupeng
 */
declare(strict_types=1);

namespace MiniIap\Drivers\Apple\Events;

use MiniIap\Contracts\PurchaseEventContract;
use MiniIap\Contracts\ServerNotificationContract;
use Mini\Support\Str;

/**
 * @deprecated Use \MiniIap\Events\EventFactory instead
 * @see \MiniIap\Events\EventFactory
 */
class EventFactory
{
    /**
     * @deprecated Use \MiniIap\Events\EventFactory::create() instead
     * @see \MiniIap\Events\EventFactory::create()
     */
    public static function create(ServerNotificationContract $notification): PurchaseEventContract
    {
        $type = $notification->getType();
        $className = "\MiniIap\Drivers\Apple\Events\\" . ucfirst(Str::camel(strtolower($type)));
        assert(class_exists($className) && is_subclass_of($className, PurchaseEventContract::class));

        return new $className($notification);
    }
}
