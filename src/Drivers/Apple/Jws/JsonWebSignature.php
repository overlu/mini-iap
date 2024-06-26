<?php
/**
 * This file is part of Mini Iap.
 * @auth lupeng
 */
declare(strict_types=1);

namespace MiniIap\Drivers\Apple\Jws;

use Lcobucci\JWT\UnencryptedToken;
use Stringable;

/**
 * JSON Web Signature (JWS) interface
 */
interface JsonWebSignature extends Stringable, UnencryptedToken
{
    /**
     * Get list of headers
     *
     * @return array
     */
    public function getHeaders(): array;

    /**
     * Get list of claims
     *
     * @return array
     */
    public function getClaims(): array;

    /**
     * Get signature
     *
     * @return string
     */
    public function getSignature(): string;
}
