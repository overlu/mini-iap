<?php
/**
 * This file is part of Mini Iap.
 * @auth lupeng
 */
declare(strict_types=1);

namespace MiniIap\Drivers\Apple\Exceptions;

use MiniIap\Drivers\Apple\ValueObjects\Status;
use Exception;

/**
 * Class InvalidReceiptException
 * @package App\Payment\Apple\Exceptions
 */
class InvalidReceiptException extends Exception
{
    public const ERROR_STATUS_MAP = Status::ERROR_STATUS_MAP;

    /**
     * @param int $status
     * @return InvalidReceiptException
     */
    public static function create(int $status): self
    {
        $msg = self::ERROR_STATUS_MAP[$status];

        return new self($msg, $status);
    }
}
