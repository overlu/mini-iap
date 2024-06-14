<?php
/**
 * This file is part of Mini Iap.
 * @auth lupeng
 */
declare(strict_types=1);

namespace MiniIap\Drivers\Google\ValueObjects;

use Psr\Http\Message\ResponseInterface;

/**
 * Empty response class.
 */
final class EmptyResponse
{
    /**
     * @var ResponseInterface
     */
    private ResponseInterface $response;

    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
    }

    public function getResponse(): ResponseInterface
    {
        return $this->response;
    }
}
