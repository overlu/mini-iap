<?php
/**
 * This file is part of Mini Iap.
 * @auth lupeng
 */
declare(strict_types=1);

namespace MiniIap\Drivers\Apple\Jws;

/**
 * JWS Parser interface
 */
interface JwsParser
{
    /**
     * Parse a JWT
     *
     * @param string $jws
     *
     * @return JsonWebSignature
     */
    public function parse(string $jws): JsonWebSignature;
}
