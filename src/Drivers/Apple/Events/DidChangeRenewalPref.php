<?php
/**
 * This file is part of Mini Iap.
 * @auth lupeng
 */
declare(strict_types=1);

namespace MiniIap\Drivers\Apple\Events;

use MiniIap\Drivers\Apple\ServerNotifications\V2DecodedPayload;
use MiniIap\Events\PurchaseEvent;
use MiniIap\Notifications\AppStoreServerNotification;
use MiniIap\Notifications\AppStoreV2ServerNotification;

/**
 * @method AppStoreServerNotification|AppStoreV2ServerNotification getServerNotification()
 */
class DidChangeRenewalPref extends PurchaseEvent
{
    public function getAutoRenewProductId(): ?string
    {
        if (
            !$this->serverNotification instanceof AppStoreServerNotification
            && !$this->serverNotification instanceof AppStoreV2ServerNotification
        ) {
            return null;
        }


        if ($this->serverNotification instanceof AppStoreServerNotification) {
            return $this->serverNotification->getAutoRenewProductId();
        }

        $payload = V2DecodedPayload::fromArray($this->serverNotification->getPayload());

        return $payload->getRenewalInfo()->getAutoRenewProductId();
    }
}
