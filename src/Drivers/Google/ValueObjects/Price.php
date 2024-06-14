<?php
/**
 * This file is part of Mini Iap.
 * @auth lupeng
 */
declare(strict_types=1);

namespace MiniIap\Drivers\Google\ValueObjects;

/**
 * Price
 * Definition of a price, i.e. currency and units.
 */
final class Price
{
    public const PRICE_MICROS = 'priceMicros';
    public const CURRENCY = 'currency';

    /**
     * @var string
     */
    private string $priceMicros;

    /**
     * @var string
     */
    private string $currency;

    /**
     * Price constructor.
     */
    public function __construct(string $priceMicros, string $currency)
    {
        $this->priceMicros = $priceMicros;
        $this->currency = $currency;
    }

    /**
     * @param array $attributes
     * @return static
     */
    public static function fromArray(array $attributes): self
    {
        return new self(
            $attributes[self::PRICE_MICROS],
            $attributes[self::CURRENCY]
        );
    }

    public function getPriceMicros(): string
    {
        return $this->priceMicros;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @return string[]
     */
    public function toArray(): array
    {
        return [
            self::PRICE_MICROS => $this->getPriceMicros(),
            self::CURRENCY => $this->getCurrency(),
        ];
    }

    /**
     * @param Price $priceObj
     * @return bool
     */
    public function equals(Price $priceObj): bool
    {
        if ($this->getCurrency() === $priceObj->getCurrency()) {
            return $this->getPriceMicros() === $priceObj->getPriceMicros();
        }

        return false;
    }
}
