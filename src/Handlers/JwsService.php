<?php
/**
 * This file is part of Mini Iap.
 * @auth lupeng
 */
declare(strict_types=1);

namespace MiniIap\Handlers;

use MiniIap\Drivers\Apple\Jws\JsonWebSignature;
use MiniIap\Drivers\Apple\Jws\JwsParser;
use MiniIap\Drivers\Apple\Jws\JwsVerifier;
use Mini\Contracts\Request;

class JwsService implements JwsServiceInterface
{
    private JwsParser $jwsParser;

    private JwsVerifier $jwsVerifier;

    private Request $request;

    private ?JsonWebSignature $jws = null;

    public function __construct(JwsParser $jwsParser, JwsVerifier $jwsVerifier, Request $request)
    {
        $this->jwsParser = $jwsParser;
        $this->jwsVerifier = $jwsVerifier;
        $this->request = $request;
    }

    /**
     * Verify the JWS.
     */
    public function verify(): bool
    {
        return $this->jwsVerifier->verify($this->jws());
    }

    private function jws(): JsonWebSignature
    {
        if (is_null($this->jws)) {
            $this->jws = $this->jwsParser->parse((string)$this->request->get('signedPayload'));
        }

        return $this->jws;
    }

    /**
     * Parses the string into a JWS.
     */
    public function parse(): JsonWebSignature
    {
        return $this->jws();
    }
}
