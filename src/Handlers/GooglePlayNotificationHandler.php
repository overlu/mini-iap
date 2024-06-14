<?php
/**
 * This file is part of Mini Iap.
 * @auth lupeng
 */
declare(strict_types=1);

namespace MiniIap\Handlers;

use MiniIap\Drivers\Google\DeveloperNotifications\DeveloperNotification;
use MiniIap\Drivers\Google\DeveloperNotifications\SubscriptionNotification;
use MiniIap\Notifications\GoogleServerNotification;
use JsonException;
use Mini\Facades\Logger;

/**
 * Google Play notification handler.
 * Handles Real time developer notifications sent by google play.
 * Dispatches the Google Play event related to the notification type.
 */
class GooglePlayNotificationHandler extends AbstractNotificationHandler
{
    /**
     * @return string[][]
     */
    protected function rules(): array
    {
        return [
            'message' => ['required', 'array'],
            'message.data' => ['required'],
        ];
    }

    /**
     * @return void
     * @throws JsonException
     */
    protected function handle(): void
    {
        $message = $this->request->input('message');
        assert(is_array($message) && isset($message['data']) && is_string($message['data']));
        $data = $message['data'];

        if (!$this->isParsable($data)) {
            Logger::info(
                sprintf('Google Play malformed RTDN: %s', json_encode($this->request->all(), JSON_THROW_ON_ERROR))
            );

            return;
        }

        $developerNotification = DeveloperNotification::parse($data);
        $googleNotification = new GoogleServerNotification($developerNotification);

        if ($developerNotification->isTestNotification()) {
            $version = $developerNotification->getPayload()->getVersion();
            Logger::info(sprintf('Google Play Test Notification, version: %s', $version));
        }

        if ($developerNotification->getPayload() instanceof SubscriptionNotification) {
            $event = $this->eventFactory->create($googleNotification);
            event($event);
        }
    }

    protected function isParsable(string $data): bool
    {
        $base64Decoded = base64_decode($data, true);
        if (false === $base64Decoded) {
            return false;
        }

        try {
            return is_array(json_decode($base64Decoded, true, 512, JSON_THROW_ON_ERROR));
        } catch (JsonException $ex) {
            return false;
        }
    }
}
