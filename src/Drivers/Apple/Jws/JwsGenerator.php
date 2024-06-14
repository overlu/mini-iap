<?php
/**
 * This file is part of Mini Iap.
 * @auth lupeng
 */
declare(strict_types=1);

namespace MiniIap\Drivers\Apple\Jws;

/**
 * JWS generator interface
 */
interface JwsGenerator
{
    /**
     * Generate a JWT
     *
     * @param array $claims
     * @param array $headers
     *
     * @return Jws
     */
    public function generate(array $claims = [], array $headers = []): JsonWebSignature;
}
