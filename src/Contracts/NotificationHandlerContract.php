<?php
/**
 * This file is part of Mini Iap.
 * @auth lupeng
 */
declare(strict_types=1);

namespace MiniIap\Contracts;

/**
 * Notification handler.
 * All server notification handlers MUST implement this contract
 */
interface NotificationHandlerContract
{
    /**
     * Executes the handler.
     */
    public function execute();
}
