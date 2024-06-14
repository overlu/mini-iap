<?php
/**
 * This file is part of Mini Iap.
 * @auth lupeng
 */
declare(strict_types=1);

namespace MiniIap\Drivers\Google\DeveloperNotifications\Builders;

use MiniIap\Drivers\Google\DeveloperNotifications\Contracts\NotificationPayload;
use MiniIap\Drivers\Google\DeveloperNotifications\Contracts\RealTimeDeveloperNotification;
use MiniIap\Drivers\Google\DeveloperNotifications\DeveloperNotification;
use MiniIap\Drivers\Google\DeveloperNotifications\Exceptions\InvalidDeveloperNotificationArgumentException;
use MiniIap\Drivers\Google\DeveloperNotifications\Factories\NotificationPayloadFactory;

/**
 * Class DeveloperNotificationBuilder
 * @package MiniIap\Drivers\Google\DeveloperNotifications\Builders
 */
final class DeveloperNotificationBuilder
{
    private ?string $version = null;

    private ?string $packageName = null;

    private ?int $eventTimeMillis = null;

    private ?NotificationPayload $payload = null;

    private ?array $decodedData = null;

    /**
     * @return static
     */
    public static function init(): self
    {
        return new self();
    }

    /**
     * @return string
     */
    public function getVersion(): string
    {
        if (null === $this->version) {
            $message = $this->buildMessage('version');

            throw new InvalidDeveloperNotificationArgumentException($message);
        }

        return $this->version;
    }

    /**
     * @param string $version
     * @return $this
     */
    public function setVersion(string $version): DeveloperNotificationBuilder
    {
        $this->version = $version;

        return $this;
    }

    /**
     * @return string
     */
    public function getPackageName(): string
    {
        if (null === $this->packageName) {
            $message = $this->buildMessage('packageName');

            throw new InvalidDeveloperNotificationArgumentException($message);
        }

        return $this->packageName;
    }

    /**
     * @param string $packageName
     * @return $this
     */
    public function setPackageName(string $packageName): DeveloperNotificationBuilder
    {
        $this->packageName = $packageName;

        return $this;
    }

    /**
     * @return int
     */
    public function getEventTimeMillis(): int
    {
        if (null === $this->eventTimeMillis) {
            $message = $this->buildMessage('eventTimeMillis');

            throw new InvalidDeveloperNotificationArgumentException($message);
        }

        return $this->eventTimeMillis;
    }

    /**
     * @param int $eventTimeMillis
     * @return $this
     */
    public function setEventTimeMillis(int $eventTimeMillis): DeveloperNotificationBuilder
    {
        $this->eventTimeMillis = $eventTimeMillis;

        return $this;
    }

    /**
     * @return NotificationPayload
     */
    public function getPayload(): NotificationPayload
    {
        if (null === $this->payload) {
            $message = $this->buildMessage('payload');

            throw new InvalidDeveloperNotificationArgumentException($message);
        }

        return $this->payload;
    }

    /**
     * @param NotificationPayload $payload
     * @return $this
     */
    public function setPayload(NotificationPayload $payload): DeveloperNotificationBuilder
    {
        $this->payload = $payload;

        return $this;
    }

    /**
     * @param array $data
     * @return $this
     */
    public function setPayloadFromArray(array $data): DeveloperNotificationBuilder
    {
        $this->payload = NotificationPayloadFactory::create($data);

        return $this;
    }

    /**
     * @return array
     */
    public function getDecodedData(): array
    {
        if (null === $this->decodedData) {
            $message = $this->buildMessage('decodedData');

            throw new InvalidDeveloperNotificationArgumentException($message);
        }

        return $this->decodedData;
    }

    /**
     * @param array $decodedData
     * @return $this
     */
    public function setDecodedData(array $decodedData): DeveloperNotificationBuilder
    {
        $this->decodedData = $decodedData;

        return $this;
    }

    /**
     * @return DeveloperNotification
     *
     * @throws InvalidDeveloperNotificationArgumentException
     */
    public function build(): RealTimeDeveloperNotification
    {
        return new DeveloperNotification($this);
    }

    /**
     * @param string $argument
     * @return string
     */
    public function buildMessage(string $argument): string
    {
        return sprintf(
            'The property `%s` is required, use the %s::set%s() to set it',
            $argument,
            self::class,
            ucfirst($argument)
        );
    }
}
