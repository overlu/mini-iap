<?php
/**
 * This file is part of Mini Iap.
 * @auth lupeng
 */
declare(strict_types=1);

namespace MiniIap\Drivers\Apple\Jws;

/**
 * JWS Verifier interface
 */
interface JwsVerifier
{
    /**
     * Verifies the JWS
     *
     * @param JsonWebSignature $jws
     *
     * @return bool
     */
    public function verify(JsonWebSignature $jws): bool;
}
