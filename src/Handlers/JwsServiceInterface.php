<?php
/**
 * This file is part of Mini Iap.
 * @auth lupeng
 */
declare(strict_types=1);

namespace MiniIap\Handlers;

use MiniIap\Drivers\Apple\Jws\JsonWebSignature;

interface JwsServiceInterface
{
    /**
     * Verify the JWS.
     */
    public function verify(): bool;

    /**
     * Parses the string into a JWS.
     */
    public function parse(): JsonWebSignature;
}
