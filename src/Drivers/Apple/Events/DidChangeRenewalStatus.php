<?php
/**
 * This file is part of Mini Iap.
 * @auth lupeng
 */
declare(strict_types=1);

namespace MiniIap\Drivers\Apple\Events;

use MiniIap\Drivers\Apple\ServerNotifications\V2DecodedPayload;
use MiniIap\Drivers\Apple\ValueObjects\JwsRenewalInfo;
use MiniIap\Events\PurchaseEvent;
use MiniIap\Notifications\AppStoreServerNotification;
use MiniIap\Notifications\AppStoreV2ServerNotification;
use MiniIap\ValueObjects\Time;

/**
 * @method AppStoreServerNotification|AppStoreV2ServerNotification getServerNotification()
 */
class DidChangeRenewalStatus extends PurchaseEvent
{
    public function isAutoRenewal(): bool
    {
        assert(
            $this->serverNotification instanceof AppStoreServerNotification
            || $this->serverNotification instanceof AppStoreV2ServerNotification
        );

        if ($this->serverNotification instanceof AppStoreServerNotification) {
            return $this->serverNotification->isAutoRenewal();
        }

        $payload = V2DecodedPayload::fromArray($this->serverNotification->getPayload());

        return JwsRenewalInfo::AUTO_RENEW_STATUS_ON === $payload->getRenewalInfo()->getAutoRenewStatus();
    }

    public function getAutoRenewStatusChangeDate(): ?Time
    {
        assert(
            $this->serverNotification instanceof AppStoreServerNotification
            || $this->serverNotification instanceof AppStoreV2ServerNotification
        );

        if ($this->serverNotification instanceof AppStoreServerNotification) {
            return $this->serverNotification->getAutoRenewStatusChangeDate();
        }

        return null;
    }
}
