<?php
/**
 * This file is part of Mini Iap.
 * @auth lupeng
 */
declare(strict_types=1);

namespace MiniIap\Drivers\Google\DeveloperNotifications\Contracts;

use MiniIap\Drivers\Google\ValueObjects\Time;

/**
 * Interface RealTimeDeveloperNotification.
 */
interface RealTimeDeveloperNotification
{
    public function getType(): string;

    public function getVersion(): string;

    public function getPackageName(): string;

    public function getEventTime(): Time;

    public function getPayload(): NotificationPayload;
}
