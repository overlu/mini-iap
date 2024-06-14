<?php
/**
 * This file is part of Mini Iap.
 * @auth lupeng
 */
declare(strict_types=1);

namespace MiniIap\Drivers\Google\Events;

use MiniIap\Contracts\PurchaseEventContract;
use MiniIap\Drivers\Google\DeveloperNotifications\SubscriptionNotification;
use MiniIap\Notifications\GoogleServerNotification;
use LogicException;
use Mini\Support\Str;
use ReflectionClass;

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
    public static function create(GoogleServerNotification $notification): PurchaseEventContract
    {
        $notificationType = (int)$notification->getType();
        $types = (new ReflectionClass(SubscriptionNotification::class))->getConstants();
        $type = array_search($notificationType, $types, true);
        if (!$type) {
            throw new LogicException("Unknown notification type: $notificationType");
        }
        $camelCaseName = ucfirst(Str::camel(strtolower($type)));
        $className = __NAMESPACE__ . "\\$camelCaseName";
        if (!class_exists($className) || !is_subclass_of($className, PurchaseEventContract::class)) {
            throw new LogicException("Invalid class: $className");
        }
        return new $className($notification);
    }
}
