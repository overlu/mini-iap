<?php
/**
 * This file is part of Mini Iap.
 * @auth lupeng
 */
declare(strict_types=1);

namespace MiniIap\Events;

use MiniIap\Contracts\EventFactory as EventFactoryContract;
use MiniIap\Contracts\PurchaseEventContract as PurchaseEvent;
use MiniIap\Contracts\ServerNotificationContract as ServerNotification;
use MiniIap\Drivers\Google\DeveloperNotifications\SubscriptionNotification;
use LogicException;
use Mini\Support\Str;
use ReflectionClass;

/**
 * This class is responsible for creating events from the given server notification
 * It should replace all vendor specific event factories.
 */
class EventFactory implements EventFactoryContract
{
    protected const NAMESPACES = [
        'google-play' => 'MiniIap\Drivers\Google\Events',
        'app-store' => 'MiniIap\Drivers\Apple\Events',
    ];

    public function create(ServerNotification $notification): PurchaseEvent
    {
        $provider = $notification->getProvider();
        if (!array_key_exists($notification->getProvider(), self::NAMESPACES)) {
            throw new LogicException("Unknown provider : $provider");
        }

        $type = $notification->getType();
        if (ServerNotification::PROVIDER_GOOGLE_PLAY === $provider) {
            $notificationType = (int)$notification->getType();
            $types = (new ReflectionClass(SubscriptionNotification::class))->getConstants();
            $type = (string)array_search($notificationType, $types, true);
        }

        $className = (string)Str::of($type)
            ->lower()
            ->studly()
            ->prepend(self::NAMESPACES[$provider] . '\\');
        if (!class_exists($className)) {
            throw new LogicException("Class $className does not exist");
        }
        if (!is_subclass_of($className, PurchaseEvent::class)) {
            throw new LogicException("Class $className is not a subclass of PurchaseEvent");
        }

        return new $className($notification);
    }
}
