<?php
/**
 * This file is part of Mini Iap.
 * @auth lupeng
 */
declare(strict_types=1);

namespace MiniIap\Exceptions;

class InvalidNotificationTypeException extends PaymentException
{
    /**
     * @param string $required
     * @param string $provided
     * @return static
     */
    public static function create(string $required, string $provided): self
    {
        return new self("Invalid notification type. Required: $required but $provided provided");
    }
}
