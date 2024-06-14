<?php
/**
 * This file is part of Mini Iap.
 * @auth lupeng
 */
declare(strict_types=1);

namespace MiniIap\Drivers\Apple\ValueObjects;

use Mini\Contracts\Support\Arrayable;

/**
 * Class AppMetadata
 * @package App\Payment\Apple\ValueObjects
 */
final class AppMetadata implements Arrayable
{
    /**
     * @var array
     */
    private array $data;

    /**
     * 防止直接实例化
     * @param array $data
     */
    private function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @param array $data
     * @return static
     */
    public static function fromArray(array $data): self
    {
        return new self($data);
    }

    /**
     * @return string
     */
    public function appAppleId(): string
    {
        return (string)$this->data['appAppleId'];
    }

    /**
     * @return string
     */
    public function bundleId(): string
    {
        return (string)$this->data['bundleId'];
    }

    /**
     * @return string
     */
    public function bundleVersion(): string
    {
        return (string)$this->data['bundleVersion'];
    }

    /**
     * @return string
     */
    public function environment(): string
    {
        return (string)$this->data['environment'];
    }

    /**
     * @return string
     */
    public function status(): string
    {
        return (string)($this->data['status'] ?? '');
    }

    /**
     * Convert the object to its array representation.
     * @return array
     */
    public function toArray(): array
    {
        return $this->data;
    }
}
