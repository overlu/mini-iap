<?php
/**
 * This file is part of Mini Iap.
 * @auth lupeng
 */
declare(strict_types=1);

namespace MiniIap\Contracts;

interface HasSubtype
{
    /**
     * Gets subscription subtype.
     */
    public function getSubtype(): string;
}
